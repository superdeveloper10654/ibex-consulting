<?php

namespace AppTenant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    /**
     * Login page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login()
    {
        return t_view('auth.login');
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
            t_guard()->attempt([
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
        t_guard()->logout();
        Session::flush();
        
        return redirect(t_route('auth.login'));
    }
}