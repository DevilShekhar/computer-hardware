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
        $meta_title = 'About Us | Computer Hardware'; 
        $meta_keyword = 'about us, computer hardware, computer parts, PC components, computer accessories';
        $meta_description = 'Learn more about our computer hardware store, our products, services, and commitment to providing quality computer parts and accessories.';
        return view('frontend.about-us.index', compact( 'meta_title', 'meta_keyword', 'meta_description' ));
    }
}