<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function send(Request $request)
    {
        // Logic to send contact email
        return redirect()->back()->with('success', 'Your message has been sent!');
    }
}
