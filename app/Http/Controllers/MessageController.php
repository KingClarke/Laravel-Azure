<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $unreadCounts = [];
        foreach ($users as $u) {
            $unreadCounts[$u->id] = \App\Models\Message::unreadFor(Auth::id())->where('sender_id', $u->id)->count();
        }
        // Sort users: those with unread messages first
        $users = $users->sortByDesc(function($user) use ($unreadCounts) {
            return $unreadCounts[$user->id] > 0 ? 1 : 0;
        })->values();
        return view('messages.index', compact('users', 'unreadCounts'));
    }

    public function show(User $user)
    {
        // Mark messages from this user as read
        \App\Models\Message::markAsRead(Auth::id(), $user->id);
        $messages = Message::where(function($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('messages.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);
        if (!$request->filled('content') && !$request->hasFile('image')) {
            return back()->withErrors(['content' => 'Message or image required.']);
        }
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->content ?? '',
            'image' => $imagePath,
        ]);
        return back();
    }
}
