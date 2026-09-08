<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() { 
        $meta_title = 'Contact Us | Computer Hardware'; 
        $meta_keyword = 'contact us, computer hardware, computer parts, PC components, computer accessories'; 
        $meta_description = 'Contact us for enquiries about computer hardware, PC components, computer parts, accessories, products and services.'; 
        return view('frontend.contact-us.index', compact( 'meta_title', 'meta_keyword', 'meta_description' )); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customerName' => 'required|string|max:255',
            'customerEmail' => 'required|email|max:255',
            'contactSubject' => 'nullable|string|max:255',
            'contactMessage' => 'required|string|max:5000',
        ]);
        Contact::create([
            'name' => $validated['customerName'],
            'email' => $validated['customerEmail'],
            'subject' => $validated['contactSubject'] ?? null,
            'message' => $validated['contactMessage'],
        ]);
        return redirect()->route('contact.thank-you')->with('success', 'Thank you! Your message has been sent successfully.');
    }
    public function thankYou()
    {
        $meta_title = 'Thank You | Computer Hardware';
        $meta_keyword = 'thank you, contact us, computer hardware, computer parts';
        $meta_description = 'Thank you for contacting us. We have received your enquiry and will get back to you soon.';
        return view('frontend.contact-us.thank-you',compact('meta_title','meta_keyword','meta_description'));
    }
}