<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
     // write in controller Route::group(['middleware'=>'auth'],function(){write route all in this block });
    public function index()
    {

        return view('dashboard');

    }
}
