<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Company;
use App\Http\Controllers\SuperAdminBaseController;
use Illuminate\Http\Request;

class ShowDashboard extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('pageTitle', __('menu.dashboard'));
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->totalCompanies = Company::select('id')->count();
        $this->activeCompanies = Company::where('status', '=', 'active')->count();
        $this->deActiveCompanies = Company::where('status', '=', 'inactive')->count();

        return view('superadmin.dashboard.index', $this->data);
    }
}
