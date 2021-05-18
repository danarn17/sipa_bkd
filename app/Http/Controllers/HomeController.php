<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function dash_webmaster()
    {
        return view('admin.dash_webmaster');
    }
    public function dash_admin()
    {
        return view('admin.dash_admin');
    }
    public function dash_author()
    {
        return view('admin.dash_author');
    }
}
