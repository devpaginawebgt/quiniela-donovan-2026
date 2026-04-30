@props(['terms'])

<div id="modal-terms" class="pointer-events-none fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">

    {{-- Backdrop --}}
    <div id="modal-terms-backdrop" class="absolute inset-0 bg-black/70 opacity-0 transition-opacity duration-300"></div>

    {{-- Panel --}}
    <div id="modal-terms-panel" class="relative bg-complementary-primary rounded-t-3xl sm:rounded-3xl overflow-hidden w-full sm:max-w-3xl max-h-[90dvh] flex flex-col translate-y-full opacity-0 transition-[transform,opacity] duration-300 ease-out p-4">

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

        {{-- Footer --}}
        <div class="shrink-0 px-6 py-4 border-t border-complementary-dark/30">
            <label class="flex items-start gap-3 mb-4 cursor-pointer w-max">
                <input
                    type="checkbox"
                    id="terms-checkbox"
                    class="mt-0.5 w-5 h-5 rounded border-complementary-light text-teal-700 focus:ring-light focus:ring-2 shrink-0"
                >
                <span class="text-sm text-complementary-light mt-0.5">He leído y acepto los términos y condiciones</span>
            </label>

            <button
                type="button"
                id="btn-confirmar-terms"
                disabled
                class="w-full bg-secondary text-complementary-primary font-bold rounded-full text-lg px-6 py-3.5 flex items-center justify-center gap-2 disabled:bg-zinc-400 disabled:opacity-40 disabled:cursor-not-allowed hover:brightness-[1.1] focus:ring-3 focus:ring-white transition-opacity"
            >
                Confirmar y Crear Cuenta
            </button>
        </div>

    </div>

    {{-- Versión de los términos (valor usado por JS) --}}
    <input type="hidden" id="terms-version-value" value="{{ $terms->version }}">
</div>
