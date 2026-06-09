<x-layouts.layout title="{{ $title }}">
    <x-front.navbar />

    <div class="container mx-auto px-4 md:px-6 lg:px-8 pt-24">
        {{ $slot }}
    </div>

</x-layouts.layout>
