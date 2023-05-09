<?php

namespace AppCentralAdmin\Http\Controllers;

use AppCentralAdmin\Services\CA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends AdminBaseController
{
    /**
     * Login page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login()
    {
        return CA::view('auth.login');
    }

    /**
     * Attempt to login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginSetup(Request $request)
    {
        $request->validate([
            'email'     => 'required|email|max:255',
            'password'  => 'required|max:255',
        ]);

        if(
            CA::guard()->attempt([
                'email'     => $request->input('email'),
                'password'  => $request->input('password')
            ])
        ) {
            return $this->jsonSuccess('Successfully logged in');
        } else {
            return $this->jsonError('Invalid credentials');
        }
    }

    /**
     * Logout
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        CA::guard()->logout();
        Session::flush();
        
        return redirect(CA::route('auth.login'));
    }
}