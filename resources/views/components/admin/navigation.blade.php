<ul class="space-y-1">
    @can('admin.ver-reportes')
    <li>
        <a href="{{ route('web.admin.reports.report') }}"
            @class([
                'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors',
                'bg-secondary text-complementary-primary font-semibold' => request()->routeIs('web.admin.reports.report'),
                'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.reports.report'),
            ])>
            <span class="icon-[material-symbols--analytics-outline-rounded] w-5 h-5"></span>
            <span>Reporte</span>
        </a>
    </li>
    @endcan

    @can('admin.enviar-notificaciones-push')
    <li>
        <a href="{{ route('web.admin.notifications.index') }}"
            @class([
                'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors',
                'bg-secondary text-complementary-primary font-semibold' => request()->routeIs('web.admin.notifications.index'),
                'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.notifications.index'),
            ])>
            <span class="icon-[material-symbols--notifications-active-outline-rounded] w-5 h-5"></span>
            <span>Notificaciones</span>
        </a>
    </li>
    @endcan
</ul>