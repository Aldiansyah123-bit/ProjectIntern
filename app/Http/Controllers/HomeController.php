<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Support\Facades\DB;

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
    public function index()
    {
        $data = [
            'title' => 'Dasboard',
            'transaction' => DB::table('transactions')->count(),
            'cart'  => DB::table('carts')->count(),
        ];
        $banners = Banner::all();
        return view('home',compact('banners'), $data);
    }
}
