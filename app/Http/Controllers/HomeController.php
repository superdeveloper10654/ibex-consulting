<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home.index');
    }

    /*Language Translation*/
    // public function lang($locale)
    // {
    //     if ($locale) {
    //         App::setLocale($locale);
    //         Session::put('lang', $locale);
    //         Session::save();
    //         return redirect()->back()->with('locale', $locale);
    //     } else {
    //         return redirect()->back();
    //     }
    // }
}
