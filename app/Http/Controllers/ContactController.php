<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);
        return redirect()->to(url()->previous() . '#bize-ulasin')
                     ->with('success', 'Mesajınız başarıyla iletildi. En kısa sürede sizinle iletişime geçeceğiz.');
                     }
}