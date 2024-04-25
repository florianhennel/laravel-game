<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @yield('title')
        </h2>
    </x-slot>

    <div class="p-12 w-full">
        @yield('content')
    </div>
</x-app-layout>
