<?php

namespace App\Http\Controllers;

use App\Exports\UsuariosExport;
use App\Http\Services\ReportService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function __construct(
        protected readonly ReportService $reportService
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
            ->addColumn('pais', fn($u) => $u->country?->name ?? 'N/A')
            ->addColumn('tipo', fn($u) => $u->type?->name ?? 'N/A')
            ->addColumn('empresa', fn($u) => $u->company?->name ?? 'N/A')
            ->addColumn('visitador', fn($u) => $u->visitor ? $u->visitor->name . ' ' . $u->visitor->lastname : 'N/A')
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
            ->filterColumn('empresa', function ($query, $keyword) {
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
}
