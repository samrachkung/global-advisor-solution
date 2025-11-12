<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Message marked as read');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully');
    }
}
