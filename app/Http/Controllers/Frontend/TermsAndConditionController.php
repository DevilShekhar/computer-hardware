<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class TermsAndConditionController extends Controller
{
    public function index()
    {
        return view('frontend.terms-and-conditions.index');
    }
}