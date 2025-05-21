@extends('messages.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5V7a4 4 0 00-8 0v2a4 4 0 00-3 3.87V17a2 2 0 002 2h10a2 2 0 002-2v-2.13A4 4 0 0017 11z" />
                </svg>
                Group: {{ $group->name }}
            </h2>
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Messages</h3>
                <div class="message-container space-y-2 bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 max-h-[700px] overflow-y-auto relative" id="group-chat-messages-container">
                    @forelse($messages as $message)
                        <div class="flex items-start gap-3">
                            <span class="flex items-center cursor-pointer" onclick="showUserCard({{ $message->sender->id }})">
                                @if($message->sender && $message->sender->profile_picture)
                                    <img src="{{ asset('storage/' . $message->sender->profile_picture) }}" alt="{{ $message->sender->name }}'s profile picture" class="h-8 w-8 rounded-full object-cover border border-gray-300 dark:border-gray-700">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-white font-bold">{{ strtoupper(substr($message->sender->name, 0, 1)) }}</div>
                                @endif
                            </span>
                            <div class="rounded-lg px-4 py-2 max-w-[80%] break-words {{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-blue-100 dark:bg-blue-900 text-gray-900 dark:text-gray-100' }}">
                                @if($message->image)
                                    <img src="{{ asset('storage/' . $message->image) }}" alt="chat image" style="width:320px;height:320px;object-fit:cover;" class="rounded cursor-pointer mb-2" onclick="showImageModal('{{ asset('storage/' . $message->image) }}')">
                                @endif
                                <span class="font-semibold {{ $message->sender_id === auth()->id() ? 'text-white' : 'text-gray-900 dark:text-white' }}">{{ $message->sender->name }}</span>
                                <span class="text-xs text-gray-400 ml-2">{{ $message->created_at->diffForHumans() }}</span>
                                <div class="{{ $message->sender_id === auth()->id() ? 'text-white' : 'text-gray-800 dark:text-gray-200' }} break-words">{{ $message->content }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">No messages yet.</p>
                    @endforelse
                </div>
                <form method="POST" action="{{ route('groups.message', $group) }}" class="flex gap-2 mt-4 items-center" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="content" placeholder="Type your message..." class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <label for="group-image-upload" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-600 hover:bg-green-700 text-white text-2xl font-bold cursor-pointer transition mr-2" title="Attach Image">
                        +
                        <input id="group-image-upload" type="file" name="image" accept="image/*" class="hidden" onchange="this.form.submit()">
                    </label>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">Send</button>
                </form>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Group Members</h3>
                <ul class="flex flex-wrap gap-2 mb-2">
                    @foreach($group->users as $member)
                        <li class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                            <span class="flex items-center cursor-pointer" onclick="showUserCard({{ $member->id }})">
                                @if($member->profile_picture)
                                    <img src="{{ asset('storage/' . $member->profile_picture) }}" alt="{{ $member->name }}'s profile picture" class="h-6 w-6 rounded-full object-cover border border-gray-300 dark:border-gray-700">
                                @else
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600 dark:bg-indigo-500 text-white text-xs font-bold">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                @endif
                            </span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</span>
                            @if($member->id !== Auth::id())
                            <form method="POST" action="{{ route('groups.removeUser', $group) }}" class="inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $member->id }}">
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-1" title="Remove">&times;</button>
                            </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ route('groups.addUser', $group) }}" class="flex gap-2 mt-2">
                    @csrf
                    <select name="user_id" required class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Add user to group...</option>
                        @foreach(\App\Models\User::where('id', '!=', Auth::id())->whereNotIn('id', $group->users->pluck('id'))->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">Add</button>
                </form>
            </div>
            <a href="{{ route('groups.index') }}" class="inline-block mt-4 text-green-600 hover:underline">&larr; Back to Groups</a>
        </div>
    </div>
</div>
<!-- User Card Modal (shared with index) -->
@if(View::hasSection('user-card-modal') === false)
<div id="user-card-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-sm w-full relative">
        <button onclick="closeUserCard()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">&times;</button>
        <div id="user-card-content">
            <!-- Content will be filled by JS -->
        </div>
    </div>
</div>
@endif
<!-- Image Modal -->
<div id="image-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 hidden">
    <div class="relative">
        <img id="modal-image" src="" alt="Full Image" class="max-h-[80vh] max-w-[90vw] rounded shadow-lg">
        <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-3xl">&times;</button>
    </div>
</div>
<script>
    if(typeof users === 'undefined') {
        const users = @json($group->users->keyBy('id'));
    }
    function showUserCard(userId) {
        const user = users[userId];
        let html = '';
        html += `<div class='flex flex-col items-center gap-2'>`;
        if(user.profile_picture) {
            html += `<img src='${window.location.origin}/storage/${user.profile_picture}' alt='${user.name} profile picture' class='h-20 w-20 rounded-full object-cover border border-gray-300 dark:border-gray-700 mb-2'>`;
        } else {
            html += `<div class='h-20 w-20 rounded-full bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-white font-bold text-2xl mb-2'>${user.name.charAt(0).toUpperCase()}</div>`;
        }
        html += `<div class='text-lg font-semibold text-gray-900 dark:text-white'>${user.name}</div>`;
        if(user.pronouns) {
            html += `<div class='text-xs text-indigo-600 dark:text-indigo-300 mb-1'>${user.pronouns}</div>`;
        }
        if(user.bio) {
            html += `<div class='text-sm text-gray-700 dark:text-gray-200 mb-2 text-center'>${user.bio}</div>`;
        }
        html += `</div>`;
        document.getElementById('user-card-content').innerHTML = html;
        document.getElementById('user-card-modal').classList.remove('hidden');
    }
    function closeUserCard() {
        document.getElementById('user-card-modal').classList.add('hidden');
    }
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeUserCard();
    });
    document.getElementById('user-card-modal').addEventListener('click', function(e) {
        if(e.target === this) closeUserCard();
    });
    function showImageModal(src) {
        document.getElementById('modal-image').src = src;
        document.getElementById('image-modal').classList.remove('hidden');
    }
    function closeImageModal() {
        document.getElementById('image-modal').classList.add('hidden');
    }
    document.getElementById('image-modal').addEventListener('click', function(e) {
        if(e.target === this) closeImageModal();
    });
    // Scroll group chat to bottom on load and after sending a message
    function scrollGroupChatToBottom() {
        const container = document.getElementById('group-chat-messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }
    document.addEventListener('DOMContentLoaded', scrollGroupChatToBottom);
    // Optional: scroll after sending a message
    const groupChatForm = document.querySelector('form[action*="groups.message"]');
    if (groupChatForm) {
        groupChatForm.addEventListener('submit', function() {
            setTimeout(scrollGroupChatToBottom, 100);
        });
    }
</script>
@endsection
