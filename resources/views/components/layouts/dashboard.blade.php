<x-layouts.layout title="{{ $title }}">

    <x-dashboard.sidebar />

    <div class="p-4 sm:ml-64">
        <div class="p-4 border border-default border-dashed rounded-base my-5">
            {{ $slot }}
        </div>
    </div>

</x-layouts.layout>
