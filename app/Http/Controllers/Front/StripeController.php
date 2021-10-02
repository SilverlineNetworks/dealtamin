<?php

namespace App\Http\Controllers\Front;

use App\Booking;
use App\BookingItem;
use App\Company;
use App\Currency;
use App\GatewayAccountDetail;
use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Notifications\BookingConfirmation;
use App\Notifications\NewBooking;
use App\Payment;
use App\PaymentGatewayCredentials;
use App\TaxSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->stripeCredentials = PaymentGatewayCredentials::withoutGlobalScope('company')->first();

        /** setup Stripe credentials **/
        Stripe::setApiKey($this->stripeCredentials->stripe_secret);
        $this->pageTitle = 'Stripe';
    }

    public function createAccountLink()
    {
        $account = \Stripe\Account::create([
            'country' => 'US',
            'type' => 'express',
        ]);

        $account_links = \Stripe\AccountLink::create([
            'account' => $account->id,
            'type' => 'account_onboarding',
            'return_url' => route('admin.returnStripeSuccess'),
            'refresh_url' => route('admin.refreshLink', $account->id),
        ]);

        $link_expire_at = Carbon::createFromTimestamp($account_links->created)->addDays(7)->diffForHumans();

        $expireDate = Carbon::createFromTimestamp($account_links->created)->addDays(7)->toDateTimeString();

        $paymentAccountData = [
            'company_id' => $this->user->company->id,
            'account_id' => $account->id,
            'link' => $account_links->url,
            'link_expire_at' => $expireDate,
            'gateway' => 'stripe',
            'connection_status' => 'not_connected',
        ];

        $details = GatewayAccountDetail::create($paymentAccountData);

        return Reply::successWithData(__('messages.createdSuccessfully'), ['details' => $details, 'link_expire_at' => $link_expire_at]);
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentWithStripe(Request $request)
    {
        $company = Booking::where(['user_id' => Auth::user()->id])->latest()->first();
        $tax_amount = TaxSetting::active()->where('company_id', $company->company_id)->first();

        $booking = Booking::with('items')->whereId($request->booking_id)->first();
        $paymentCredentials = PaymentGatewayCredentials::withoutGlobalScope('company')->first();
        $stripeAccountDetails = GatewayAccountDetail::activeConnectedOfGateway('stripe')->first();

        $line_items = [];

        foreach ($booking->items as $key => $value) {
            $name = ($value->business_service_id == null) ? $value->product->name : $value->businessService->name;
            $price = ($value->business_service_id == null) ? $value->unit_price * 100 : ($value->unit_price * $tax_amount->percent) + $value->unit_price * 100;

            $line_items[] = [
                'name' => $name,
                'amount' => $price,
                'currency' => $this->settings->currency->currency_code,
                'quantity' => $value->quantity,
            ];
        }

        $amount = $booking->amount_to_pay * 100;
        $name = Auth::user()->name;
        $destination = $stripeAccountDetails ? $stripeAccountDetails->account_id : '';

        $applicationFee = round(($amount / 100) * $paymentCredentials->stripe_commission_percentage);

        if ($destination != null && $destination != '') {
            $data = [
                'payment_method_types' => ['card'],
                'line_items' => [$line_items],
                'payment_intent_data' => [
                    'application_fee_amount' => $applicationFee,
                    'transfer_data' => [
                        'destination' => $destination,
                    ],
                ],
                'success_url' => route('front.afterStripePayment',$request->return_url),
                'cancel_url' => route('front.payment-gateway'),
            ];
        } elseif ($destination == null && $destination == '') {
            $data = [
                'payment_method_types' => ['card'],
                'line_items' => [$line_items],
                'success_url' => route('front.afterStripePayment', $request->return_url),
                'cancel_url' => route('front.payment-gateway'),
            ];
        }

        $session = \Stripe\Checkout\Session::create($data);

        session(['stripe_session' => $session]);

        return Reply::dataOnly(['id' => $session->id]);
    }

    public function afterStripePayment(Request $request, $return_url, $bookingId = null)
    {
        $session_data = session('stripe_session');
        $session = \Stripe\Checkout\Session::retrieve($session_data->id);

        $payment_method = \Stripe\PaymentIntent::retrieve(
            $session->payment_intent,
            []
        );

        if ($bookingId == null) {
            $invoice = Booking::where([
                'user_id' => Auth::user()->id,
            ])
                ->latest()
                ->first();
        } else {
            $invoice = Booking::where(['id' => $bookingId, 'user_id' => Auth::user()->id])->first();
        }

        $setting = Company::with('currency')->where('id', $invoice->company_id)->first();
        $currency = $setting->currency;

        $payment = new Payment();
        $payment->booking_id = $invoice->id;
        $payment->currency_id = $currency->id;
        $payment->customer_id = $this->user->id;
        $payment->amount = $invoice->amount_to_pay;
        $payment->gateway = 'Stripe';
        $payment->transaction_id = $payment_method->id;
        $payment->transfer_status = 'not_transferred';
        if ($payment_method->transfer_data && !is_null($payment_method->transfer_data->destination)) {
            $payment->transfer_status = 'transferred';
        }
        $payment->paid_on = Carbon::now();
        $payment->status = $payment_method->status == 'succeeded' ? 'completed' : 'pending';
        $payment->save();

        $invoice->payment_gateway = 'Stripe';
        $invoice->payment_status = 'completed';
        $invoice->save();

        // send email notifications
        $company = Booking::where(['user_id' => Auth::user()->id])->latest()->first();
        $admins = User::allAdministrators()->where('company_id', $company->company_id)->first();
        Notification::send($admins, new NewBooking($invoice));

        $user = User::findOrFail($invoice->user_id);
        $user->notify(new BookingConfirmation($invoice));

        \Session::put('success', __('messages.paymentSuccessAmount') . $currency->currency_symbol . $invoice->amount_to_pay);

        if ($return_url == 'booking_url') {

            return redirect()->route('admin.bookings.index');

        }elseif ($return_url == 'backend') {

            return redirect()->route('admin.calendar');
        }
        return $this->redirectToPayment($bookingId, 'Payment success');
    }

    public function redirectToPayment($id, $message)
    {
        if ($id == null) {
            return redirect()->route('front.payment.success')->with(['message' => $message]);
        }
        return redirect()->route('front.payment.success')->with(['id' => $id, 'message' => $message]);
    }

    public function redirectToErrorPage($id, $message)
    {

        \Session::put('error', __('messages.errorMessage'));

        if ($id == null) {
            return Reply::redirect(route('front.payment.fail'), $message);
        }
        return Reply::redirect(route('front.payment.fail', $id), $message);
    }
}
