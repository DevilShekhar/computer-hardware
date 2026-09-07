<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    /**
     * Display all contact submissions.
     */
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contact-submissions.index', compact('contacts'));
    }    
}
