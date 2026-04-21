<ul class="space-y-1">
    @can('admin.ver-reportes')
    <li>
        <a href="{{ route('web.admin.reports.users.index') }}"
            @class([ 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors' , 'bg-secondary text-complementary-primary font-semibold'=> request()->routeIs('web.admin.reports.users.*'),
            'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.reports.users.*'),
            ])>
            <span class="icon-[material-symbols--group-outline-rounded] w-5 h-5"></span>
            <span>Usuarios Registrados</span>
        </a>
    </li>
    @endcan

    {{-- Ejemplo para futuros módulos: --}}
    @can('admin.enviar-notificaciones-push')
    <li>
        <a href="{{-- route('web.admin.notificaciones') --}}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-light hover:bg-complementary-primary/60">
            <span class="icon-[material-symbols--notifications-active-outline-rounded] w-5 h-5"></span>
            <span>Notificaciones</span>
        </a>
    </li>
    @endcan
</ul>