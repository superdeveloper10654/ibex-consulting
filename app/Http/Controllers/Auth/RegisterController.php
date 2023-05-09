<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Base\BaseController;
use App\Providers\RouteServiceProvider;
use App\Models\Profile;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'organisation'  => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:profiles'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
            'avatar'        => ['required', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Profile
     */
    protected function create(array $data)
    {
        if (request()->has('avatar')) {            
            $avatar = request()->file('avatar');
            $avatarName = time() . '-' . $avatar->getClientOriginalName() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = config('path.images.profiles');
            $avatar->move($avatarPath, $avatarName);
        }
        
        $profile = Profile::create([
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'organisation'      => $data['organisation'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'avatar'            => config('path.images.profiles') . "/" . $avatarName,
            'department'        => Department::COMMERCIAL_ID,
            'role'              => Role::ADMIN_ID,
            'team_users_count'  => env('TEAM_USERS_COUNT_MIN'),
        ]);

        return $profile;
    }
}