<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Auth::user()->groups;
        $unreadGroupCounts = [];
        foreach ($groups as $group) {
            $unreadGroupCounts[$group->id] = $group->messages()
                ->whereNull('read_at')
                ->where('sender_id', '!=', Auth::id())
                ->count();
        }
        return view('messages.groups', compact('groups', 'unreadGroupCounts'));
    }

    public function show(Group $group)
    {
        // Mark all unread messages in this group as read for the current user
        $group->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', Auth::id())
            ->update(['read_at' => now()]);
        $messages = $group->messages()->orderBy('created_at', 'asc')->get();
        return view('messages.group_show', compact('group', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $group = Group::create(['name' => $request->name]);
        $group->users()->attach(Auth::id());
        return redirect()->route('groups.show', $group);
    }

    public function addUser(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $group->users()->syncWithoutDetaching($request->user_id);
        return back();
    }

    public function removeUser(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $group->users()->detach($request->user_id);
        return back();
    }

    public function sendMessage(Request $request, Group $group)
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
            'group_id' => $group->id,
            'content' => $request->content ?? '',
            'image' => $imagePath,
        ]);
        return back();
    }
}
