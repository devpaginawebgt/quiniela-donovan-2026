@props([
    'label',
    'id',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'maxlength' => null,
    'minlength' => null,
    'pattern' => null,
    'title' => null,
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
        <input
            id="{{ $id }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            @if($maxlength) maxlength="{{ $maxlength }}" @endif
            @if($minlength) minlength="{{ $minlength }}" @endif
            @if($pattern) pattern="{{ $pattern }}" @endif
            @if($title) title="{{ $title }}" @endif
            {{ $attributes->merge(['class' => 'w-full py-3 bg-light text-dark rounded-xl border-0 focus:ring-2 focus:ring-secondary placeholder-gray-500 text-sm ' . (isset($prefix) ? 'ps-10' : 'ps-4')]) }}
        >
    </div>
</div>
