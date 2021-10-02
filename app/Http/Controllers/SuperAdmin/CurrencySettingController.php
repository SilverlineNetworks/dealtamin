<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Currency;
use App\Helper\Reply;
use App\Http\Requests\Currency\StoreCurrency;
use App\Http\Controllers\SuperAdminBaseController;

class CurrencySettingController extends SuperAdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreCurrency $request)
    {
        $currency = new Currency();
        $currency->currency_name = $request->currency_name;
        $currency->currency_code = $request->currency_code;
        $currency->currency_symbol= $request->currency_symbol;
        $currency->save();

        return Reply::success(__('messages.createdSuccessfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency = Currency::find($id);
        return view('superadmin.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCurrency $request, $id)
    {
        $currency = Currency::find($id);
        $currency->currency_name = $request->currency_name;
        $currency->currency_code = $request->currency_code;
        $currency->currency_symbol= $request->currency_symbol;
        $currency->save();

        return Reply::redirect(route('superadmin.settings.index'), __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Currency::destroy($id);

        return Reply::success(__('messages.recordDeleted'));
    }
}
