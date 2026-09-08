<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $meta_title = 'Privacy Policy | Computer Hardware';
        $meta_keyword = 'privacy policy, computer hardware, computer parts, data privacy, customer information';
        $meta_description = 'Read our Privacy Policy to understand how we collect, use, protect and manage customer information when you use our computer hardware website and services.';
        return view('frontend.privacy-policy.index',compact('meta_title','meta_keyword','meta_description'));
    }
}