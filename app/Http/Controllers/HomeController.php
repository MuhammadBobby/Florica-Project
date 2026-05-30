<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class HomeController extends Controller
{
    //============ LANDING PAGE =============
    public function index()
    {
        return view('landing.index');
    }
}
