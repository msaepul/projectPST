<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HoController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('ho.dashboard');
    }

    public function cabang(Request $request)
    {
        return view('ho.cabang');
    } 
    
    public function tujuan(Request $request)
    {
        return view('ho.tujuan');
    }    
    public function departemen(Request $request)
    {
        return view('ho.departemen');
    }
}
