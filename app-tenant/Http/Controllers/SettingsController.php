<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisation_logo = Setting::getLink(Setting::KEY_ORGANISATION_LOGO);
        $landing_image = Setting::getLink(Setting::KEY_LANDING_IMAGE);

        return t_view('settings.index', compact('organisation_logo', 'landing_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $this->validateSettings($request);

        $file_name = $this->maybeSaveSettingFile(Setting::KEY_ORGANISATION_LOGO, $request);
        if ($file_name) {
            Setting::set(Setting::KEY_ORGANISATION_LOGO, $file_name);
        }

        $file_name = $this->maybeSaveSettingFile(Setting::KEY_LANDING_IMAGE, $request);
        if ($file_name) {
            Setting::set(Setting::KEY_LANDING_IMAGE, $file_name);
        }

        return $this->jsonSuccess('Updated successfully');
    }

    /**
     * Validates data on store/update requests
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateSettings(Request $request)
    {
        $data = [
            Setting::KEY_LANDING_IMAGE      => 'file|image|max:5120',
            Setting::KEY_ORGANISATION_LOGO  => 'file|image|max:2048',
        ];

        $request->validate($data);
    }

    /**
     * Save files in settings storage folder from post request
     * 
     * @param string $post_file_name
     * @param  \Illuminate\Http\Request  $request
     * @return string|false
     */
    protected function maybeSaveSettingFile($post_file_name, Request $request)
    {
        $file = $request->file($post_file_name);

        if ($file) {
            $existing_file = Setting::getPath($post_file_name);

            if ($existing_file) {
                Storage::disk('public')->delete($existing_file);
            }

            $name = Str::random() . '.' . $file->getClientOriginalExtension();
            $path = config('path.files.settings') . "/$name";
            Storage::disk('public')->put($path, $file->get());

            return $name;
        }

        return false;
    }
}
