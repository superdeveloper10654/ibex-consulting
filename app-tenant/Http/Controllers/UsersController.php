<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Profile;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::paginate(config('app.pagination_size'));
       
        return t_view('users.index', [
            'profiles'  => $profiles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::getArray();

        return t_view('users.create', [
            'departments'   => Department::getArray(),
            'roles'         => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $optional_fields = [];
        $roles = Role::getArray();
        
        $request->validate(array_merge([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'nullable|string|max:255',
            'email'                 => 'required|string|email|unique:AppTenant\Models\Profile,email',
            'password'              => 'required|confirmed|min:8',
            'organisation'          => 'nullable|string|max:255',
            'department'            => 'required|in:' . implode(',', array_keys(Department::getArray())),
            'role'                  => 'required|in:' . implode(',', array_keys($roles)),
            'avatar'                => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ], $optional_fields));

        $profile = new Profile();
        $this->fillProfileDataFromRequest($profile, $request);
        $profile->team_users_count = env('TEAM_USERS_COUNT_MIN');
        $profile->save();
        
        return redirect()->route('users.show', $profile->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        $roles = Role::getArray();

        return t_view('users.show', [
            'profile'       => $profile,
            'departments'   => Department::getArray(),
            'roles'         => $roles,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id)
    {
        
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
        $profile = Profile::findOrFail($id);

        $optional_fields = [];
        $roles = Role::getArray();

        $request->validate(array_merge([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'email'             => 'required|string|email',
            'organisation'      => 'nullable|string|max:255',
            'department'        => 'required|in:' . implode(',', array_keys(Department::getArray())) . '|',
            'role'              => 'required|in:' . implode(',', array_keys($roles)),
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'new_password'      => 'nullable|confirmed|min:8',
        ], $optional_fields));

        $this->fillProfileDataFromRequest($profile, $request);
        $profile->update();
        
        return redirect()->route('users.show', $profile->id);
    }

    /**
     * Fill profile fields using request fields
     * 
     * @param  \AppTenant\Models\Profile  $profile
     * @param  \Illuminate\Http\Request  $request
     */
    protected function fillProfileDataFromRequest(Profile $profile, Request $request)
    {
        $profile->first_name = $request->get('first_name');
        $profile->last_name = $request->get('last_name');
        $profile->email = $request->get('email');
        $profile->organisation = $request->get('organisation');
        $profile->department = $request->get('department');
        $profile->role = $request->get('role');

        if ($request->get('password')) {
            $profile->password = Hash::make($request->get('password'));
        }

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = config('path.images.profiles');
            $avatar->move($avatarPath, $avatarName);

            // remove old avatar
            if (!empty($profile->avatar)) {
                unlink(config('path.images.profiles') . $profile->avatar);
            }

            $profile->avatar = $avatarName;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if (!empty($profile->avatar)) {
            unlink(config('path.images.profiles') . $profile->avatar);
        }

        if ($profile->subscribed()) {
            $profile->subscription()->cancelNow();
        }

        $profile->delete();

        return redirect( t_route('users'));
    }
    //4753

    /**
     * Unsubscribe the user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->subscription()->cancelNow();

        return back();
    }
}
