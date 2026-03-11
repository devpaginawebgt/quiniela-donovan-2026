@props([
    'id'          => 'search',
    'name'        => 'search',
    'placeholder' => 'Buscar...',
])

<div class="relative w-full">
    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
        <svg class="w-5 h-5 text-complementary-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </div>
    <input
        type="text"
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
        {{ $attributes->merge(['class' => 'w-full bg-complementary-primary border border-secondary text-light placeholder-complementary-light rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-secondary']) }}
    >
</div>
