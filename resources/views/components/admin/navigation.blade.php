<ul class="space-y-1">
    @can('read admin reports')
    <li>
        <a href="{{ route('web.admin.reports.users.index') }}"
            @class([ 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors' , 'bg-secondary text-complementary-primary font-semibold'=> request()->routeIs('web.admin.reports.users.*'),
            'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.reports.users.*'),
            ])>
            <span class="icon-[material-symbols--group-outline-rounded] w-5 h-5"></span>
            <span>Usuarios Registrados</span>
        </a>
    </li>
    <li>
        <a href="{{ route('web.admin.reports.predictions.index') }}"
            @class([ 'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors' , 'bg-secondary text-complementary-primary font-semibold'=> request()->routeIs('web.admin.reports.predictions.*'),
            'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.reports.predictions.*'),
            ])>
            <span class="icon-[material-symbols--fact-check-outline-rounded] w-5 h-5"></span>
            <span>Pronósticos Registrados</span>
        </a>
    </li>
    @endcan

    @can('create admin notifications')
    <li>
        <a href="{{ route('web.admin.notifications.create') }}"
            @class([
                'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors',
                'bg-secondary text-complementary-primary font-semibold' => request()->routeIs('web.admin.notifications.create'),
                'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.notifications.create'),
            ])>
            <span class="icon-[material-symbols--notifications-active-outline-rounded] w-5 h-5"></span>
            <span>Notificaciones</span>
        </a>
    </li>
    @endcan

    @can('manage match polling')
    <li>
        <a href="{{ route('web.admin.match-score-requests.index') }}"
            @class([
                'flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors',
                'bg-secondary text-complementary-primary font-semibold' => request()->routeIs('web.admin.match-score-requests.*'),
                'text-light hover:bg-complementary-primary/60' => ! request()->routeIs('web.admin.match-score-requests.*'),
            ])>
            <span class="icon-[material-symbols--scoreboard-outline-rounded] w-5 h-5"></span>
            <span>Notificación de marcadores</span>
        </a>
    </li>
    @endcan
</ul>