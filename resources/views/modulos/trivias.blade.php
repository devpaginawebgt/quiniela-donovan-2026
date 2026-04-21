<x-app-layout>
    <x-inicio-header :activeTab="'trivia'" />

    <x-carousel-section-banners :banners="$banners" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <div class="px-6 pb-6">

                <h1 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Trivias</h1>

                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-search-input id="buscar-trivias" name="buscar_trivias" placeholder="Buscar trivias" />
                </div>

                @if(isset($quizzes) && !empty($quizzes))
                    <ul id="trivias-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4 2xl:gap-8 max-w-4xl mx-auto min-h-32 py-8">
                        @foreach($quizzes as $quiz)
                            <x-quiz-card :quiz="$quiz" />
                        @endforeach
                    </ul>
                @else
                    <p class="text-2xl text-zinc-300 w-full flex justify-center items-center py-16">
                        No hay trivias para mostrar en este momento
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
