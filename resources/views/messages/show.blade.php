<x-messages.layout>
    <div class="w-full flex justify-center">
        <div class="w-full max-w-3xl bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s profile picture" class="h-10 w-10 rounded-full object-cover border border-gray-300 dark:border-gray-700 cursor-pointer" onclick="showUserCard({{ $user->id }})">
                        @else
                            <div class="h-10 w-10 rounded-full bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-white font-bold text-lg cursor-pointer" onclick="showUserCard({{ $user->id }})">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $user->name }}
                        </h2>
                    </div>
                    <a href="{{ route('messages.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                        Back to messages
                    </a>
                </div>

                <div class="message-container space-y-2 bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 max-h-[700px] overflow-y-auto" id="chat-messages-container">
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} items-center gap-3">
                            @if($message->sender && $message->sender->profile_picture)
                                <img src="{{ asset('storage/' . $message->sender->profile_picture) }}" alt="{{ $message->sender->name }}'s profile picture" class="h-10 w-10 rounded-full object-cover border border-gray-300 dark:border-gray-700 cursor-pointer" onclick="showUserCard({{ $message->sender->id }})">
                            @elseif($message->sender)
                                <div class="h-10 w-10 rounded-full bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-white font-bold cursor-pointer" onclick="showUserCard({{ $message->sender->id }})">
                                    {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="{{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-blue-100 dark:bg-blue-900 text-gray-900 dark:text-gray-100' }} rounded-lg px-6 py-4 max-w-[60%] break-words">
                                @if($message->image)
                                    <img src="{{ asset('storage/' . $message->image) }}" alt="chat image" style="width:320px;height:320px;object-fit:cover;" class="rounded cursor-pointer mb-2" onclick="showImageModal('{{ asset('storage/' . $message->image) }}')">
                                @endif
                                <p class="text-base break-words">{{ $message->content }}</p>
                                <span class="text-xs {{ $message->sender_id === auth()->id() ? 'opacity-75' : 'text-gray-600 dark:text-gray-400' }}">{{ $message->created_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('messages.store', $user) }}" method="POST" class="flex gap-2 items-center" enctype="multipart/form-data">
                    @csrf
                    <input type="text" 
                           name="content" 
                           placeholder="Type your message..." 
                           class="flex-1 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-black-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400">
                    <label for="image-upload" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-2xl font-bold cursor-pointer transition mr-2" title="Attach Image">
                        +
                        <input id="image-upload" type="file" name="image" accept="image/*" class="hidden" onchange="this.form.submit()">
                    </label>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- User Card Modal (shared) -->
    <div id="user-card-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-sm w-full relative">
            <button onclick="closeUserCard()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">&times;</button>
            <div id="user-card-content">
                <!-- Content will be filled by JS -->
            </div>
        </div>
    </div>
    <!-- Image Modal -->
    <div id="image-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 hidden">
        <div class="relative">
            <img id="modal-image" src="" alt="Full Image" class="max-h-[80vh] max-w-[90vw] rounded shadow-lg">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-3xl">&times;</button>
        </div>
    </div>
    <script>
        const users = @json([$user->id => $user] + $messages->pluck('sender')->keyBy('id')->toArray());
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

        // Scroll chat to bottom on load and after sending a message
        function scrollChatToBottom() {
            const container = document.getElementById('chat-messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
        document.addEventListener('DOMContentLoaded', scrollChatToBottom);
        // Optional: scroll after sending a message
        const chatForm = document.querySelector('form[action*="messages.store"]');
        if (chatForm) {
            chatForm.addEventListener('submit', function() {
                setTimeout(scrollChatToBottom, 100);
            });
        }
    </script>
</x-messages.layout>
