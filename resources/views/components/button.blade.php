<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-secondary text-dark font-semibold rounded-md text-sm px-4 py-2 hover:brightness-[1.10] focus:ring-4 focus:ring-light']) }}>
    {{ $slot }}
</button>