<x-guest-layout>
    <div class="w-full max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Contact Us</h2>
        
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-white-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Subject</label>
                    <input type="text" 
                           name="subject" 
                           id="subject" 
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Message</label>
                    <textarea name="message" 
                              id="message" 
                              rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Send Message
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                Back to Home
            </a>
        </div>
    </div>
</x-guest-layout>
