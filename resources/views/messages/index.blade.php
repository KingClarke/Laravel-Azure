<x-messages.layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Messages
                    </h2>
                    <div class="relative">
                        <input type="text" 
                               id="search"  
                               placeholder="Search users..." 
                               class="w-64 pl-10 pr-4 py-2 border rounded-lg border-gray-600 bg-black text-black placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($users as $user)
                        <div class="block p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition duration-150 group relative @if(!empty($unreadCounts[$user->id])) ring-2 ring-red-500 bg-red-50 dark:bg-red-900/30 @endif hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex items-center space-x-4">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s profile picture" class="h-12 w-12 rounded-full object-cover border border-gray-300 dark:border-gray-700 cursor-pointer" onclick="event.stopPropagation(); showUserCard({{ $user->id }})">
                                @else
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-white font-bold text-lg cursor-pointer" onclick="event.stopPropagation(); showUserCard({{ $user->id }})">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('messages.show', $user) }}" class="flex items-center gap-2 focus:outline-none">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 mb-0">
                                            {{ $user->name }}
                                        </p>
                                        <span class="flex-shrink-0 text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- User Card Modal -->
    <div id="user-card-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-sm w-full relative">
            <button onclick="closeUserCard()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">&times;</button>
            <div id="user-card-content">
                <!-- Content will be filled by JS -->
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            
            document.querySelectorAll('.grid > a').forEach(card => {
                const userName = card.querySelector('p').textContent.toLowerCase();
                card.style.display = userName.includes(searchTerm) ? 'block' : 'none';
            });
        });

        const users = @json($users->keyBy('id'));
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
        // Prevent modal click from closing chat
        document.getElementById('user-card-modal').addEventListener('click', function(e) {
            if(e.target === this) closeUserCard();
        });
    </script>
</x-messages.layout>
