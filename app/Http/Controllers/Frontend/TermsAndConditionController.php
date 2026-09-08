<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
class TermsAndConditionController extends Controller
{
    public function index()
    {
        $meta_title = 'Terms & Conditions | Computer Hardware';
        $meta_keyword = 'terms and conditions, computer hardware, computer parts, website terms, purchase terms';
        $meta_description = 'Read our Terms and Conditions to understand the rules, policies, purchase terms and conditions for using our computer hardware website and services.';
        return view('frontend.terms-and-conditions.index',compact('meta_title','meta_keyword','meta_description'));
    }
}