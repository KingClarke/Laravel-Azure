<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        // Add user_id if user is logged in
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        Contact::create($validated);

        return back()->with('success', 'Thank you for your message. We will contact you soon!');
    }
}
