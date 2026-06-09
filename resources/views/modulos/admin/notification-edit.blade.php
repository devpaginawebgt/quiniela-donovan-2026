<x-admin-layout>
    <div class="max-w-screen-2xl 2xl:w-screen-2xl mx-auto h-full flex-1 flex justify-center items-center">
        @can('create admin notifications')
            @include('modulos.admin.partials.notification-form', ['notification' => $notification])
        @endcan
    </div>
</x-admin-layout>
