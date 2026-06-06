@props(['title', 'subTitle'])

<div class="mb-8">
    <h1 class="text-3xl font-bold text-heading">
        {{ $title }}
    </h1>

    <p class="mt-2 text-body">
        {{ $subTitle ?? 'Selamat datang di dashboard Florica.' }}
    </p>
</div>
