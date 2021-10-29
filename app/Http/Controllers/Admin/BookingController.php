<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\BookingItem;
use App\BusinessService;
use App\Company;
use App\Coupon;
use App\Helper\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Location;
use App\Notifications\BookingCancel;
use App\Notifications\BookingReminder;
use App\TaxSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\BookingStatusMultiUpdate;
use App\Http\Requests\Booking\UpdateBooking;
use App\Payment;
use App\PaymentGatewayCredentials;
use App\Product;
use Illuminate\Support\Facades\Crypt;
use Mail;

class BookingController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->credentials = PaymentGatewayCredentials::first();
        $setting = Company::with('currency')->first();

        view()->share('pageTitle', __('menu.bookings'));
        view()->share('credentials', $this->credentials);
        view()->share('setting', $setting);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking') && !$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking'), 403);

        if(\request()->ajax())
        {
            $bookings = Booking::orderBy('date_time', 'desc')
            ->with([
            'user'=> function($q)
                {
                    $q->withoutGlobalScope('company');
                }
            ]);

            if(\request('filter_sort') != ""){
                $bookings->orderBy('id', \request('filter_sort'));
            }

            if(\request('filter_status') != ""){
                $bookings->where('bookings.status', \request('filter_status'));
            }

            if (\request('filter_customer') != "") {
                $customer = request()->filter_customer;
                $bookings->where('user_id', $customer);
            }

            if(\request('filter_location') != ""){
                $bookings->leftJoin('booking_items', 'bookings.id', 'booking_items.booking_id')
                    ->leftJoin('business_services', 'booking_items.business_service_id', 'business_services.id')
                    ->leftJoin('locations', 'business_services.location_id', 'locations.id')
                    ->select('bookings.*')
                    ->where('locations.id', request('filter_location'))
                    ->groupBy('bookings.id');
            }

            if(\request('filter_date') != ""){
                $startTime = Carbon::createFromFormat('Y-m-d', request('filter_date'), $this->settings->timezone)->setTimezone('UTC')->startOfDay();
                $endTime = $startTime->copy()->addDay()->subSecond();

                $bookings->whereBetween('bookings.date_time', [$startTime, $endTime]);
            }

            if(!$this->user->is_admin && !$this->user->can('create_booking')){
                ($this->user->is_employee) ? $bookings->whereHas('users', function($q)
                {
                    $q->where('user_id', $this->user->id);
                })->orWhere('user_id', $this->user->id) : $bookings->where('bookings.user_id', $this->user->id);
            }

            $bookings = $bookings->get();

            return \datatables()->of($bookings)
                ->editColumn('id', function ($row) {
                    $view = view('admin.booking.list_view', compact('row'))->render();
                    return $view;
                })
                ->rawColumns(['id'])
                ->toJson();
        }
        $customers = User::withoutGlobalScopes()->has('customerBookings')->get();

        $locations = Location::all();
        $status = \request('status');

        return view('admin.booking.index', compact('customers', 'status', 'locations'));
    }

    public function calendar()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking') && !$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking'), 403);

        if($this->user->hasRole('customer')){
            $bookings = Booking::with([
                'user'=> function($q)
                    {
                        $q->withoutGlobalScope('company')->where('id', $this->user->id);
                    }
                ])->where('status', '!=', 'canceled')->where('user_id', $this->user->id)->get();

        } elseif ($this->user->hasRole('employee')) {
            $bookings = Booking::with([
                'user'=> function($q)
                    {
                        $q->withoutGlobalScope('company');
                    }
                ])->where(function($q){
                    $q->where('status', '!=', 'canceled');
                    $q->where(function($q){
                        $q->where('user_id', $this->user->id);
                        $q->orWhere(function($q){
                            $q->whereHas('users', function($q){
                                $q->where('id', $this->user->id);
                            });
                        });
                    });
                })
                ->get();
        } elseif ($this->user->is_admin) {
            $bookings = Booking::with([
                'user'=> function($q)
                    {
                        $q->withoutGlobalScope('company');
                    }
                ])->where(function($q){
                    $q->where('status', '!=', 'canceled');
                })
                ->get();
        }

        return view('admin.booking.calendar_index', compact('bookings', $bookings));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('read_booking') && !$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('create_booking'), 403);

        $booking = Booking::with([
            'users' => function($q) { $q->withoutGlobalScope('company'); } ,
            'coupon' => function($q) { $q->withoutGlobalScope('company'); } ,
            'user' => function($q) { $q->withoutGlobalScope('company'); } ,
            ])
            ->find($id);

        /*
        if ($tax_details->tax_type == 1 && !empty($tax->percent)) {
            $sub_total += round($products[$k]['price'],2);
            $vat = ($products[$k]['price'] * $tax->percent) / 100;
            $estimated_vat += $vat;
            $products[$k]['sub_price'] = $products[$k]['price'];
            $products[$k]['vat'] = $vat;
            $products[$k]['total'] = round($vat + $products[$k]['sub_price'],2);
        }
        else {
            $without_vat = $products[$k]['price'] * 100 / (100 + $tax->percent);
            $products[$k]['sub_price'] = round($without_vat, 2);
            $sub_total += $without_vat;
            $including_vat += round($products[$k]['price'] - $without_vat,2);
            $products[$k]['vat'] = round($products[$k]['price'] - $without_vat,2);
            $products[$k]['total'] = round($products[$k]['vat'] + $without_vat,2);
        }
        */



        $tax = TaxSetting::active()->first();
        $sub_total = $estimated_vat = $including_vat = 0;
        foreach($booking->items AS $item) {
            $service_id = $item->business_service_id;
            $tax_details = DB::Table('business_services')->select('tax_type', 'tax_percentage')->where('id', $service_id)->first();

            if ($tax_details->tax_type == 1 && !empty($tax->percent)) {
                $sub_total += round($item->unit_price,2);
                $vat = ($item->unit_price * $tax->percent) / 100;
                $estimated_vat += $vat;
                $item->sub_price = $item->unit_price;
                $item->vat = $vat;
                $item->total = round($vat + $item->sub_price,2);
                $item->vat_percentage = $tax->percent;
            }
            else {
                $without_vat = $item->unit_price * 100 / (100 + $tax->percent);
                $item->sub_price = round($without_vat, 2);
                $sub_total += $without_vat;
                $including_vat += round($item->unit_price - $without_vat,2);
                $item->vat = round($item->unit_price - $without_vat,2);
                $item->total = round($item->vat + $without_vat,2);
                $item->vat_percentage = '';
            }
        }

        $current_url = ($request->current_url != null) ? $request->current_url: 'backend';
        $commonCondition = $booking->payment_status == 'pending' && $booking->status != 'canceled' && $this->credentials->show_payment_options == 'show' && !$this->user->is_admin && !$this->user->is_employee;

        $view = view('admin.booking.show', compact('including_vat','estimated_vat','sub_total','booking', 'commonCondition', 'current_url'))->render();

        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        abort_if(!$this->user->can('update_booking'), 403);

        $selected_booking_user = array();
        $booking_users = Booking::with([
            'users' => function($q) { $q->withoutGlobalScope('company'); } ])
            ->find($booking->id);
        foreach ($booking_users->users as $key => $user)
        {
            array_push($selected_booking_user, $user->id);
        }

        $booking = Booking::with([
            'users' => function($q) { $q->withoutGlobalScope('company'); } ,
            'user' => function($q) { $q->withoutGlobalScope('company'); },
            'deal' => function($q) { $q->withoutGlobalScope('company'); } ,
            'deal.location' => function($q) { $q->withoutGlobalScope('company'); } ,
            'items' => function($q) { $q->withoutGlobalScope('company'); }
        ])
        ->find($booking->id);

        $tax = TaxSetting::active()->first();
        $employees = User::OtherThanCustomers()->get();
        $businessServices = BusinessService::active()->get();
        $products = Product::active()->get();
        $view = view('admin.booking.edit', compact('booking', 'tax', 'products', 'businessServices', 'employees', 'selected_booking_user'))->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBooking $request, $id)
    {
        abort_if(!$this->user->can('update_booking'), 403);

        /* these are product varibles */
        $products       = $request->cart_products;
        $productQty     = $request->product_quantity;
        $productPrice   = $request->product_prices;

        $types          = $request->types;
        $employees      = $request->employee_id;
        $services       = $request->item_ids;
        $quantity       = $request->cart_quantity;
        $prices         = $request->item_prices;
        $discount       = $request->cart_discount;
        $payment_status = $request->payment_status;
        $discountAmount = 0;
        $originalProductAmt = 0;
        $amountToPay    = 0;

        $originalAmount = 0;
        $bookingItems = array();
        $taxAmount = 0;
        /* save services and deals */
        if(!is_null($services))
        {
            foreach ($services as $key=>$service)
            {
                $amount = ($quantity[$key] * $prices[$key]);

                $deal_id = ($types[$key] == 'deal') ? $services[$key] : null;
                $service_id = ($types[$key] == 'service') ? $services[$key] : null;

                $bookingItems[] = [
                    "business_service_id" => $service_id,
                    "quantity" => $quantity[$key],
                    "unit_price" => $prices[$key],
                    "amount" => $amount,
                    "deal_id" => $deal_id,
                ];

                $originalAmount = ($originalAmount + $amount);
                $tax_details = DB::Table('business_services')->select('tax_type', 'tax_percentage')->where('id', $service_id)->first();

                if ($tax_details->tax_type == 1 && !empty($tax_details->tax_percentage)) {
                    $taxAmount += ($tax_details->tax_percentage / 100) * $amount;
                }
            }
        }



        /* save products */
        if(!is_null($products))
        {
            foreach ($products as $key=>$product){
                $productAmt = ($productQty[$key] * $productPrice[$key]);

                $productItems[] = [
                    "product_id" => $product,
                    "quantity" => $productQty[$key],
                    "unit_price" => $productPrice[$key],
                    "amount" => $productAmt
                ];

                $originalProductAmt = ($originalProductAmt + $productAmt);
            }
        }

        $amountToPay = $originalAmount;

        $booking = Booking::where('id', $id)
        ->with([
            'payment' => function($q) { $q->withoutGlobalScope('company'); },
            'user' => function($q) { $q->withoutGlobalScope('company'); },
            ])
            ->first();



        if($discount > 0){
            if($discount > 100) $discount = 100;

            $discountAmount = (($discount/100) * $originalAmount);
            $amountToPay = ($originalAmount - $discountAmount);
        }

        if($booking->tax_name){
            //$taxAmount = $amountToPay * $booking->tax_percent / 100;
            //$booking->tax_amount = $taxAmount;
        }

        $amountToPay = ($amountToPay + $taxAmount);

        if (!is_null($request->coupon_id)) {
            $amountToPay -= $request->coupon_amount;
        }

        if($originalProductAmt > 0){
            $amountToPay = ($amountToPay + $originalProductAmt);
        }

        $amountToPay = round($amountToPay, 2);

        $booking->date_time   = Carbon::createFromFormat('Y-m-d H:i a', $request->booking_date . ' ' . $request->hidden_booking_time)->format('Y-m-d H:i:s');
        $booking->status      = $request->status;
        $booking->original_amount = $originalAmount;
        $booking->product_amount = $originalProductAmt;
        $booking->discount = $discountAmount;
        $booking->discount_percent = $request->cart_discount;;
        $booking->amount_to_pay = $amountToPay;
        $booking->payment_status = $payment_status;

        $booking->save();
        $company_id = $booking->company_id;
        $company = DB::Table('companies')->where('id', $company_id)->first();

        /*SEND REVIEW MAIL BOOKING EMAIL */
        //$request->status

        if ($request->status === 'completed') {
            $data = array(
                'name'=> $booking->user->name,
                'id' => Crypt::encryptString($id),
                'booking_id' => $id,
                'booking_date' => $booking->date_time,
                'vendor_name' => $company->company_name,
                'company_phone' => $company->company_phone
            );

            $to_name = $booking->user->name;
            $to_email = $booking->user->email;

            Mail::send('emails.booking_completed', $data, function($message) use ($to_name,$to_email, $id, $company) {
                $message->to($to_email, $to_name)->subject('Thank You! Your Booking Is Completed (Booking Number #: '.$id.')');
                $message->from($company->company_email,$company->company_name);
            });
        }


        /* assign employees to this appointment */
        if(!empty($employees))
        {
            $assignedEmployee   = array();
            foreach ($employees as $key=>$employee)
            {
                $assignedEmployee[] = $employees[$key];
            }
            $booking = Booking::with([
                'payment' => function($q) { $q->withoutGlobalScope('company'); },
                'user' => function($q) { $q->withoutGlobalScope('company'); },
                'users' => function($q) { $q->withoutGlobalScope('company'); },
            ])->find($id);
            $booking->users()->sync($assignedEmployee);
        }

        //delete old items and enter new booking_date
        BookingItem::where('booking_id', $id)->delete();

        $total_amount = 0.00;
        if(!is_null($services)){
            foreach ($bookingItems as $key=>$bookingItem){
                $bookingItems[$key]['booking_id'] = $booking->id;
                $bookingItems[$key]['company_id'] = $booking->company_id;
                $total_amount += $bookingItem['amount'];
            }
            DB::table('booking_items')->insert($bookingItems);
        }

        $total_amt = 0.00;

        if(!is_null($products)){

            foreach ($productItems as $key=>$productItem){
                $productItems[$key]['booking_id'] = $booking->id;
                $productItems[$key]['company_id'] = $booking->company_id;
                $total_amt += $productItem['amount'];
            }
            DB::table('booking_items')->insert($productItems);
        }

        if (!$booking->payment) {

            $payment = new Payment();
            $payment->currency_id = $this->settings->currency_id;
            $payment->booking_id = $booking->id;
            $payment->amount = $amountToPay;
            $payment->gateway = 'cash';
            $payment->status = $payment_status;
            $payment->paid_on = Carbon::now();
        }
        else {
            $payment = $booking->payment;
            $payment->status = $payment_status;
            $payment->amount = $amountToPay;
        }
        $payment->save();

        $current_url = ($request->current_url != null) ? $request->current_url: 'backend';
        $commonCondition = $booking->payment_status == 'pending' && $booking->status != 'canceled' && $this->credentials->show_payment_options == 'show' && !$this->user->is_admin && !$this->user->is_employee;

        $completedBookings = Booking::where('user_id', $booking->user_id)->where('status', 'completed')->count();
        $approvedBookings = Booking::where('user_id', $booking->user_id)->where('status', 'approved')->count();
        $pendingBookings = Booking::where('user_id', $booking->user_id)->where('status', 'pending')->count();
        $canceledBookings = Booking::where('user_id', $booking->user_id)->where('status', 'canceled')->count();
        $inProgressBookings = Booking::where('user_id', $booking->user_id)->where('status', 'in progress')->count();
        $earning = Booking::where('user_id', $booking->user_id)->where('status', 'completed')->sum('amount_to_pay');

        $view = view('admin.booking.show', compact('booking', 'commonCondition', 'current_url'))->render();

        $customerStatsView = view('partials.customer_stats', compact('completedBookings', 'approvedBookings', 'pendingBookings', 'inProgressBookings', 'canceledBookings', 'earning'))->render();

        return Reply::successWithData('messages.updatedSuccessfully', ['status' => 'success', 'view' => $view, 'customerStatsView' => $customerStatsView]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('delete_booking'), 403);

        Booking::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

    public function download($id)
    {

        $booking = Booking::with([
            'users' => function($q) { $q->withoutGlobalScope('company'); } ,
            'user' => function($q) { $q->withoutGlobalScope('company'); } ,
            ])
            ->find($id);

        abort_if($booking->status != 'completed', 403);

        if($this->user->is_admin || $this->user->is_employee || $booking->user_id == $this->user->id){

            $pdf = app('dompdf.wrapper');
            $pdf->loadView('admin.booking.receipt',compact('booking') );
            $filename = __('app.receipt').' #'.$booking->id;
            return $pdf->download($filename . '.pdf');
        }
        else{
            abort(403);
        }
    }

    public function requestCancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'canceled';
        $booking->save();

        $commonCondition = $booking->payment_status == 'pending' && $booking->status != 'canceled' && $this->credentials->show_payment_options == 'show' && !$this->user->is_admin && !$this->user->is_employee;
        $view = view('admin.booking.show', compact('booking', 'commonCondition'))->render();

        $admins = User::allAdministrators()->get();
        $role = $this->user->is_admin == true && $this->user->is_employee == false ? 'Admin' : 'Customer';

        Notification::send($admins, new BookingCancel($booking, $role));

        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function sendReminder()
    {
        $bookingId = \request('bookingId');
        $booking = Booking::findOrFail($bookingId);

        $customer = User::withoutGlobalScopes()->findOrFail($booking->user_id);

        $customer->notify(new BookingReminder($booking));

        return Reply::success(__('messages.bookingReminderSent'));
    }

    public function multiStatusUpdate(BookingStatusMultiUpdate $request)
    {

        foreach ($request->booking_checkboxes as $key => $booking_checkbox)
        {
            $booking = Booking::find($booking_checkbox);
            $booking->status = $request->change_status;
            $booking->save();
        }
        return Reply::dataOnly(['status' => 'success', '']);
    }

    public function updateCoupon(Request $request)
    {
        $couponId = $request->coupon_id;

        $tax = TaxSetting::active()->first();

        $productAmount = $request->cart_services;

        if($request->cart_discount > 0){
            $totalDiscount = ($request->cart_discount / 100) * $productAmount;
            $productAmount -= $totalDiscount;
        }

        $percentAmount = ($tax->percent / 100) * $productAmount;

        $totalAmount   = ($productAmount + $percentAmount);

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $couponData = Coupon::where('coupons.start_date_time', '<=', $currentDate)
            ->where(function ($query) use($currentDate) {
                $query->whereNull('coupons.end_date_time')
                    ->orWhere('coupons.end_date_time', '>=', $currentDate);
            })
            ->where('coupons.id', $couponId)
            ->where('coupons.status', 'active')
            ->first();

        if (!is_null($couponData)  && $couponData->minimum_purchase_amount != 0 && $couponData->minimum_purchase_amount != null && $productAmount < $couponData->minimum_purchase_amount)
        {
            return Reply::errorWithoutMessage();
        }

        if (!is_null($couponData) && $couponData->used_time >= $couponData->uses_limit && $couponData->uses_limit != null && $couponData->uses_limit != 0) {
            return Reply::errorWithoutMessage();
        }

        if (!is_null($couponData)) {
            $days = json_decode($couponData->days);
            $currentDay = Carbon::now()->format('l');
            if (in_array($currentDay, $days)) {
                if (!is_null($couponData->percent) && $couponData->percent != 0) {
                    $percentAmnt = round(($couponData->percent / 100) * $totalAmount, 2);
                    if (!is_null($couponData->amount) && $percentAmnt >= $couponData->amount) {
                        $percentAmnt = $couponData->amount;
                    }
                    return Reply::dataOnly( ['amount' => $percentAmnt, 'couponData' => $couponData]);
                } elseif (!is_null($couponData->amount) && (is_null($couponData->percent) || $couponData->percent == 0)) {
                    return Reply::dataOnly(['amount' => $couponData->amount, 'couponData' => $couponData]);
                }
            } else {
                return Reply::errorWithoutMessage();
            }
        }
        return Reply::errorWithoutMessage();
    }

    public function updateBookingDate(Request $request, $id)
    {
        abort_if(!$this->user->can('update_booking'), 403);

        $booking = Booking::where('id', $id)->first();
        $booking->date_time   = Carbon::parse($request->startDate)->format('Y-m-d H:i:s');
        $booking->save();

        return Reply::successWithData('messages.updatedSuccessfully', ['status' => 'success']);
    }



 } /* end of class */
