@props(['terms'])

<div id="modal-terms-readonly" class="pointer-events-none fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">

    {{-- Backdrop --}}
    <div id="modal-terms-readonly-backdrop" class="absolute inset-0 bg-black/70 opacity-0 transition-opacity duration-300"></div>

    {{-- Panel --}}
    <div id="modal-terms-readonly-panel" class="relative bg-complementary-primary rounded-t-3xl sm:rounded-3xl overflow-hidden w-full sm:max-w-3xl max-h-[90dvh] flex flex-col translate-y-full opacity-0 transition-[transform,opacity] duration-300 ease-out p-4">

        {{-- Header --}}
        <div class="shrink-0 pt-4 pb-4 px-6">
            <img
                src="{{ asset('images/logos/logo-white.png') }}"
                class="w-full max-w-60 mx-auto"
                alt="{{ config('app.name', 'Quiniela') }}"
            >
            <div class="w-full h-0.5 bg-secondary mt-3"></div>
        </div>

        {{-- Scrollable content --}}
        <div class="overflow-y-auto flex-1 px-6 pb-4">
            <div class="prose prose-invert prose-sm max-w-none
                prose-headings:text-light prose-headings:font-bold
                prose-p:text-complementary-light prose-p:leading-relaxed
                prose-a:text-secondary prose-a:no-underline hover:prose-a:underline
                prose-strong:text-light
                prose-li:text-complementary-light
            ">
                {!! Str::markdown($terms->content) !!}
            </div>
        </div>

    </div>
</div>
