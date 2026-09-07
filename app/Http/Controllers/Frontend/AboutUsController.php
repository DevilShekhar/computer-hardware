<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    /**
     * Display the About Us page.
     */
    public function index()
    {
        return view('frontend.about-us.index');
    }
}