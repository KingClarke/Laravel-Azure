@extends('messages.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5V7a4 4 0 00-8 0v2a4 4 0 00-3 3.87V17a2 2 0 002 2h10a2 2 0 002-2v-2.13A4 4 0 0017 11z" />
                </svg>
                Your Groups
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                @forelse($groups as $group)
                    <a href="{{ route('groups.show', $group) }}" class="block p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition duration-150 group @if(!empty($unreadGroupCounts[$group->id])) ring-2 ring-red-500 bg-red-50 dark:bg-red-900/30 @endif hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-green-600 dark:bg-green-500 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($group->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-lg font-medium text-gray-900 dark:text-white truncate group-hover:text-green-600 dark:group-hover:text-green-400">
                                    {{ $group->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $group->users->count() }} member{{ $group->users->count() === 1 ? '' : 's' }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 text-gray-400 dark:text-gray-500 group-hover:text-green-600 dark:group-hover:text-green-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">You have no groups yet.</p>
                @endforelse
            </div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2 mt-8">Create New Group</h3>
            <form method="POST" action="{{ route('groups.store') }}" class="flex flex-col sm:flex-row gap-4 items-center">
                @csrf
                <input type="text" name="name" placeholder="Group Name" required class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">Create Group</button>
            </form>
        </div>
    </div>
</div>
@endsection
