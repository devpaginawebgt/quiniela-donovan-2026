@props([
    'label',
    'id',
    'name',
    'required' => false,
])

<div>
    <label for="{{ $id }}" class="block text-sm font-bold text-light mb-1.5">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <div class="relative">
        @if(isset($prefix))
            <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3.5 pointer-events-none text-complementary-dark">
                {{ $prefix }}
            </div>
        @endif
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'w-full py-3 bg-light text-dark rounded-xl border-0 focus:ring-2 focus:ring-secondary text-sm ' . (isset($prefix) ? 'ps-11' : 'ps-4')]) }}
        >
            {{ $slot }}
        </select>
    </div>
</div>
