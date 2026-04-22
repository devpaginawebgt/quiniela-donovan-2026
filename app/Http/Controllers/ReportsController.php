<?php

namespace App\Http\Controllers;

use App\Exports\PronosticosExport;
use App\Exports\UsuariosExport;
use App\Http\Services\PrediccionService;
use App\Http\Services\ReportService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function __construct(
        protected readonly ReportService $reportService,
        protected readonly PrediccionService $prediccionService,
    ) {}

    public function report()
    {
        return view('modulos.admin.users');
    }

    public function data()
    {
        $query = $this->reportService->getUsuarios();

        return DataTables::eloquent($query)
            ->addColumn('nombre_completo', fn($u) => $u->nombres . ' ' . $u->apellidos)
            ->addColumn('numero_documento', fn($u) => $u->numero_documento ?? 'N/A')
            ->addColumn('direccion', fn($u) => $u->direccion ?? 'N/A')
            ->addColumn('colegiado', fn($u) => $u->colegiado ?? 'N/A')
            ->addColumn('pais', fn($u) => $u->country?->name ?? 'N/A')
            ->addColumn('tipo', fn($u) => $u->type?->name ?? 'N/A')
            ->addColumn('cadena', fn($u) => $u->company?->name ?? 'N/A')
            ->addColumn('visitador', fn($u) => $u->visitor ? $u->visitor->name . ' ' . $u->visitor->lastname : 'N/A')
            ->addColumn('region', fn($u) => $u->region ?? 'N/A')
            ->addColumn('capital', fn($u) => $u->capital ?? 'N/A')
            ->addColumn('farmacia', fn($u) => $u->branch ?? 'N/A')
            ->addColumn('fecha_registro', fn($u) => $u->created_at->format('d/m/Y h:i A'))
            ->addColumn('estado_badge', function ($u) {
                if ($u->status_user) {
                    return '
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border bg-green-100 text-green-700 border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                            Activo
                        </span>
                    ';
                }

                return '
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border bg-red-100 text-red-700 border-red-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                        Inactivo
                    </span>
                ';
            })

            ->addColumn('notificaciones_badge', function ($u) {

                $tieneNotif = $u->pushTokens
                    ->where('is_active', true)
                    ->isNotEmpty();

                if ($tieneNotif) {
                    return '
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border bg-green-100 text-green-700 border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                            Sí
                        </span>
                    ';
                }

                return '
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border bg-red-100 text-red-700 border-red-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                        No
                    </span>
                ';
            })
            ->filterColumn('nombre_completo', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nombres', 'like', "%{$keyword}%")
                        ->orWhere('apellidos', 'like', "%{$keyword}%")
                        ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$keyword}%"]);
                });
            })
            ->filterColumn('pais', function ($query, $keyword) {
                $query->whereHas('country', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('tipo', function ($query, $keyword) {
                $query->whereHas('type', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('cadena', function ($query, $keyword) {
                $query->whereHas('company', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('visitador', function ($query, $keyword) {
                $query->whereHas('visitor', fn($q) => $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%{$keyword}%"]));
            })
            ->rawColumns(['estado_badge', 'notificaciones_badge'])
            ->make(true);
    }

    public function export(Request $request)
    {
        $search = (string) ($request->get('search') ?? '');

        $fileName = 'usuarios_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new UsuariosExport($search), $fileName);
    }

    public function predictionsReport()
    {
        return view('modulos.admin.predictions');
    }

    public function predictionsData()
    {
        $query = $this->reportService->getPronosticos();

        return DataTables::eloquent($query)
            ->addColumn('usuario', fn($p) => $p->user->nombres . ' ' . $p->user->apellidos)
            ->addColumn('email', fn($p) => $p->user->email)
            ->addColumn('numero_documento', fn($p) => $p->user->numero_documento ?? 'N/A')
            ->addColumn('telefono', fn($p) => $p->user->telefono ?? 'N/A')
            ->addColumn('direccion', fn($p) => $p->user->direccion ?? 'N/A')
            ->addColumn('colegiado', fn($p) => $p->user->colegiado ?? 'N/A')
            ->addColumn('pais', fn($p) => $p->user->country?->name ?? 'N/A')
            ->addColumn('tipo', fn($p) => $p->user->type?->name ?? 'N/A')
            ->addColumn('cadena', fn($p) => $p->user->company?->name ?? 'N/A')
            ->addColumn('visitador', fn($p) => $p->user->visitor
                ? $p->user->visitor->name . ' ' . $p->user->visitor->lastname
                : 'N/A')
            ->addColumn('region', fn($p) => $p->user->region ?? 'N/A')
            ->addColumn('capital', fn($p) => $p->user->capital ?? 'N/A')
            ->addColumn('farmacia', fn($p) => $p->user->branch ?? 'N/A')
            ->addColumn('partido', function ($p) {
                $equipos = $p->partido?->equipos;
                if (!$equipos) return 'N/A';
                $e1 = $equipos->equipoUno?->nombre ?? '?';
                $e2 = $equipos->equipoDos?->nombre ?? '?';
                return "{$e1} VS {$e2}";
            })
            ->addColumn('jornada', fn($p) => $p->partido?->jornada ? 'Jornada ' . $p->partido->jornada->name : 'N/A')
            ->addColumn('fecha_partido', fn($p) => $p->partido?->fecha_partido?->format('d/m/Y H:i A') ?? 'N/A')
            ->addColumn('fecha_registro', fn($p) => $p->created_at->format('d/m/Y H:i A'))
            ->addColumn('fecha_actualizacion', fn($p) => $p->updated_at->format('d/m/Y H:i A'))
            ->addColumn('pronostico', fn($p) => $p->goles_equipo_1 . ' - ' . $p->goles_equipo_2)
            ->addColumn('resultado_real', function ($p) {
                $r = $p->resultado;
                if (!$r) return '<span class="text-gray-600 text-sm">Sin resultado</span>';
                return $r->goles_equipo_1 . ' - ' . $r->goles_equipo_2;
            })
            ->addColumn('puntos_badge', function ($p) {
                $pts = $this->prediccionService->getResultadoPrediccion($p, $p->resultado);
                $color = match ($pts) {
                    3 => 'bg-green-100 text-green-700 border-green-200',
                    1 => 'bg-blue-100 text-blue-700 border-blue-200',
                    default => 'bg-gray-100 text-gray-500 border-gray-200',
                };
                return "
                    <span class=\"inline-flex items-center justify-center px-2.5 py-0.5 text-xs font-bold rounded-full border {$color}\">
                        {$pts} pts
                    </span>
                ";
            })
            ->addColumn('estado_badge', function ($p) {
                if ($p->status === 1) {
                    return '
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border bg-green-100 text-green-700 border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                            Pronosticado
                        </span>
                    ';
                }
                return '
                   <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border bg-red-100 text-red-700 border-red-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Pendiente
                    </span>
                ';
            })
            ->filterColumn('usuario', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('nombres', 'like', "%{$keyword}%")
                        ->orWhere('apellidos', 'like', "%{$keyword}%")
                        ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$keyword}%"]);
                });
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$keyword}%"));
            })
            ->filterColumn('pais', function ($query, $keyword) {
                $query->whereHas('user.country', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('tipo', function ($query, $keyword) {
                $query->whereHas('user.type', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('cadena', function ($query, $keyword) {
                $query->whereHas('user.company', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('visitador', function ($query, $keyword) {
                $query->whereHas('user.visitor', fn($q) => $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%{$keyword}%"]));
            })
            ->filterColumn('jornada', function ($query, $keyword) {
                $query->whereHas('partido.jornada', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->rawColumns(['resultado_real', 'puntos_badge', 'estado_badge'])
            ->make(true);
    }

    public function predictionsExport(Request $request)
    {
        $search = (string) ($request->get('search') ?? '');

        $fileName = 'pronosticos_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new PronosticosExport($search), $fileName);
    }
}
