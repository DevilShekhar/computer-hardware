<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact-us.index');
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
        return view('frontend.contact-us.thank-you');
    }
}