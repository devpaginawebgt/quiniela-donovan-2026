@props([
    'id'    => 'select',
    'name'  => 'select',
    'label' => null,
])

<div class="w-full flex items-center gap-2 border-b border-complementary-light pb-1">
    @if($label)
        <label for="{{ $id }}" class="text-light font-bold whitespace-nowrap">{{ $label }}</label>
    @endif
    <div class="w-full relative flex items-center">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none;"
            {{ $attributes->merge(['class' => 'form-select-custom bg-transparent text-light font-bold cursor-pointer focus:outline-none border-none w-full pr-6']) }}
        >
            {{ $slot }}
        </select>
        <svg class="pointer-events-none absolute right-0 w-4 h-4 text-complementary-light shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
</div>
