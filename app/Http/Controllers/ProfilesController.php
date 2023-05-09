<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Models\Profile;
use App\Models\Statical\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilesController extends BaseController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id != Constant::ME) {
            abort(404);
        }
        
        $profile = Auth::user();

        return view('central.web.profiles.edit', [
            'profile_id'    => $id,
            'profile'       => $profile,
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
        if ($id != Constant::ME) {
            abort(404);
        }

        $profile = Auth::user();

        $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'email'             => 'required|string|email',
            'organisation'      => 'nullable|string|max:255',
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'password'          => 'nullable|confirmed|min:8',
        ]);

        $this->fillProfileDataFromRequest($profile, $request, Constant::ACTION_UPDATE);
        $profile->update();

        return $this->jsonSuccess('Updated');
    }

    /**
     * Fill profile fields using request fields
     * 
     * @param  \App\Models\Profile  $profile
     * @param  \Illuminate\Http\Request  $request
     * @param string $action store/update
     */
    protected function fillProfileDataFromRequest(Profile $profile, Request $request, $action)
    {
        $profile->first_name = $request->get('first_name');
        $profile->last_name = $request->get('last_name');
        $profile->email = $request->get('email');
        $profile->organisation = $request->get('organisation');

        if ($request->get('password')) {
            $profile->password = Hash::make($request->get('password'));
        }

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = Str::random() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = config('path.images.profiles') . "/$avatarName";
            Storage::disk('public')->put($avatarPath, $avatar->get());

            // remove old avatar
            $file = config('path.images.profiles') . $profile->avatar;

            if (!empty($profile->avatar) && file_exists($file) && $profile->avatar != Constant::IMG_PATH_PUBLIC_SUPPORT) {
                Storage::disk('public')->delete($file);
            }

            $profile->avatar = $avatarName;
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
        $profile = Auth::user();

        if (!(Hash::check($request->get('current_password'), $profile->password))) {
            return $this->jsonError("Your Current password does not matches with the password you provided. Please try again."); 
        }

        $profile->password = Hash::make($request->get('new_password'));
        $profile->update();

        return $this->jsonSuccess('Password updated successfully');
    }
}
