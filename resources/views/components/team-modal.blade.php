<div id="modal-equipo" class="pointer-events-none fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">

    {{-- Backdrop --}}
    <div id="modal-equipo-backdrop" class="absolute inset-0 bg-black/70 opacity-0 transition-opacity duration-300"></div>

    {{-- Panel --}}
    <div id="modal-equipo-panel" class="relative bg-complementary-primary rounded-t-3xl sm:rounded-3xl overflow-hidden w-full sm:max-w-xl max-h-[90dvh] flex flex-col translate-y-full opacity-0 transition-[transform,opacity] duration-300 ease-out">

        {{-- Header --}}
        <div class="flex items-center justify-end px-4 pt-3 pb-2 shrink-0">
            <div class="hidden sm:flex flex-1"></div>
            <button
                id="modal-equipo-close"
                type="button"
                class="shrink-0 bg-complementary-light/10 hover:bg-complementary-light/20 text-light rounded-full p-1.5 transition-colors"
                aria-label="Cerrar"
            >
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Scrollable content --}}
        <div class="overflow-y-auto">
            <div class="px-6">
                <img
                    id="modal-equipo-img"
                    src=""
                    alt=""
                    class="w-full aspect-video object-cover rounded-2xl"
                >
            </div>
            <div class="p-6 flex flex-col gap-3">
                <h3 id="modal-equipo-nombre" class="font-bold text-2xl text-center"></h3>
                <p id="modal-equipo-descripcion" class="text-complementary-light text-sm leading-relaxed text-justify"></p>
            </div>
        </div>

    </div>
</div>
