<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\NotificationSetting;
use Illuminate\Http\Request;

class NotificationSettingsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = NotificationSetting::paginate(config('app.pagination_size'));

        return t_view('notification-settings.index', [
            'settings'  => $settings
        ]);
    }


    protected function edit($id)
    {
        $setting = NotificationSetting::findOrFail($id);

        return t_view('notification-settings.edit', [
            'setting'  => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = NotificationSetting::findOrFail($id);
        $request->validate([
            // 'value'        => 'required',
            'status'        => 'in:0,1',
        ]);
        $setting->value = $request->value;
        $setting->status = $request->status ?? 0;
        $setting->save();

        return redirect()->route('notification-settings');
    }
}
