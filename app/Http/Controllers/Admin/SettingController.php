<?php

namespace App\Http\Controllers\Admin;

use App\BookingTime;
use App\Company;
use App\Currency;
use App\GatewayAccountDetail;
use App\Helper\Files;
use App\Helper\Formats;
use App\Helper\Permissions;
use App\Helper\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Setting\UpdateSetting;
use App\Language;
use App\Media;
use App\Module;
use App\ModuleSetting;
use App\PaymentGatewayCredentials;
use App\Permission;
use App\Role;
use App\SmsSetting;
use App\SmtpSetting;
use App\TaxSetting;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.settings'));
    }

    public function index()
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('manage_settings'), 403);

        $bookingTimes = BookingTime::all();
        $images = Media::select('id', 'image')->latest()->get();
        $tax = TaxSetting::first();
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $dateFormats = Formats::dateFormats();
        $timeFormats = Formats::timeFormats();
        $dateObject = Carbon::now($this->settings->timezone);
        $currencies = Currency::all();
        $enabledLanguages = Language::where('status', 'enabled')->orderBy('language_name')->get();
        $smtpSetting = SmtpSetting::first();
        $credentialSetting = PaymentGatewayCredentials::first();
        $smsSetting = SmsSetting::first();
        $roles = Role::whereNotIn('name', ['superadmin', 'administrator'])->get();
        $totalPermissions = Permission::count();
        $modules = Module::whereIn('name', Permissions::getModules($this->user->role))->get();
        $moduleSettings = ModuleSetting::where('status', 'deactive')->get();
        $employees = User::AllEmployees()->get();

        $client = new Client();
        $res = $client->request('GET', config('froiden_envato.updater_file_path'), ['verify' => false]);
        $lastVersion = $res->getBody();
        $lastVersion = json_decode($lastVersion, true);
        $currentVersion = File::get('version.txt');

        $description = $lastVersion['description'];

        $newUpdate = 0;
        if (version_compare($lastVersion['version'], $currentVersion) > 0) {
            $newUpdate = 1;
        }
        $updateInfo = $description;
        $lastVersion = $lastVersion['version'];

        $appVersion = File::get('version.txt');
        $laravel = app();
        $laravelVersion = $laravel::VERSION;

        $stripePaymentSetting = GatewayAccountDetail::ofStatus('active')->ofGateway('stripe')->first();
        $razoypayPaymentSetting = GatewayAccountDetail::ofStatus('active')->ofGateway('razorpay')->first();

        return view('admin.settings.index', compact('moduleSettings', 'stripePaymentSetting', 'razoypayPaymentSetting', 'bookingTimes', 'images', 'tax', 'timezones', 'dateFormats', 'timeFormats', 'dateObject', 'currencies', 'enabledLanguages', 'smtpSetting', 'lastVersion', 'updateInfo', 'appVersion', 'laravelVersion', 'newUpdate', 'credentialSetting', 'smsSetting', 'roles', 'totalPermissions', 'modules'));
    }

    public function update(UpdateSetting $request, $id)
    {
        abort_if(!$this->user->roles()->withoutGlobalScopes()->first()->hasPermission('manage_settings'), 403);
        $company = User::with('company')->where('id', auth()->user()->id)->first();

        $setting = Company::findOrFail($company->company->id);
        $setting->company_name = $request->company_name;
        $setting->company_email = $request->company_email;
        $setting->company_phone = $request->company_phone;
        $setting->address = $request->address;
        $setting->date_format = $request->date_format;
        $setting->time_format = $request->time_format;
        $setting->website = $request->website;
        $setting->timezone = $request->timezone;
        $setting->locale = $request->input('locale');
        $setting->currency_id = $request->currency_id;
        if ($request->hasFile('logo')) {
            $setting->logo = Files::upload($request->logo, 'company-logo');
        }
        $setting->save();

        if ($setting->currency->currency_code !== 'INR') {
            $credential = PaymentGatewayCredentials::first();

            if ($credential->razorpay_status == 'active') {
                $credential->razorpay_status = 'deactive';

                $credential->save();
            }
        }
        return Reply::redirect(route('admin.settings.index'), __('messages.updatedSuccessfully'));
    }

    public function changeLanguage($code)
    {
        $language = Language::where('language_code', $code)->first();
        if ($language) {
            $this->settings->locale = $code;
        } else if ($code == 'en') {
            $this->settings->locale = 'en';
        }
        $this->settings->save();
        return Reply::success(__('messages.languageChangedSuccessfully'));
    }

    public function saveBookingTimesField(Request $request)
    {
        $company = User::with('company')->where('id', auth()->user()->id)->first();

        $setting = Company::findOrFail($company->company->id);
        $setting->booking_per_day = $request->no_of_booking_per_customer;
        $setting->multi_task_user = $request->multi_task_user;
        $setting->employee_selection = $request->employee_selection;
        $setting->disable_slot = $request->disable_slot;
        $setting->booking_time_type = $request->booking_time_type;
        $setting->save();

        if ($request->disable_slot == 'enabled') {
            DB::table('payment_gateway_credentials')->where('id', 1)->update(['show_payment_options' => 'hide', 'offline_payment' => 1]);
        }

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function moduleSetting()
    {
        $package_modules = json_decode($this->package->package_modules, true) ?: [];

        $admin_modules = ModuleSetting::select('module_name')->where(['type' => 'administrator', 'status' => 'active'])->get()->map(function ($item, $key) {return $item->module_name;})->toArray();

        $employee_modules = ModuleSetting::select('module_name')->where(['type' => 'employee', 'status' => 'active'])->get()->map(function ($item, $key) {return $item->module_name;})->toArray();

        return view('admin.settings.module-settings', compact('package_modules', 'admin_modules', 'employee_modules'));
    }

    public function updateModuleSetting(Request $request)
    {
        $company = User::with('company')->where('id', auth()->user()->id)->first();

        ModuleSetting::where(['company_id' => $company->company->id, 'module_name' => $request->module_name, 'type' => $request->user_type])
            ->update(['status' => $request->status]);

        return Reply::success(__('messages.updatedSuccessfully'));
    }

} /* end of class */
