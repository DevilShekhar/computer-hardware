<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DisclaimerController extends Controller
{
    public function index()
    {
        $meta_title = 'Disclaimer | Computer Hardware'; 
        $meta_keyword = 'computer hardware disclaimer, website disclaimer, product disclaimer, computer parts'; 
        $meta_description = 'Read our website disclaimer for information about computer hardware products, prices, specifications, availability and website content.';
        return view('frontend.disclaimer.index', compact( 'meta_title', 'meta_keyword', 'meta_description' ));
    }
}