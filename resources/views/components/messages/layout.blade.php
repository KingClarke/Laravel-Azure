<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Messages
        </h2>
    </x-slot>

    <div class="py-12">
        {{ $slot }}
    </div>
</x-app-layout>
