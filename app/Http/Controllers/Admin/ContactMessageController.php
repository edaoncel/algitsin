<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);

        $messages = ContactMessage::latest()->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();
        return back()->with('success', 'Mesaj başarıyla silindi.');
    }
}