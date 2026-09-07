<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DisclaimerController extends Controller
{
    public function index()
    {
        return view('frontend.disclaimer.index');
    }
}