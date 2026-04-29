<?php

namespace App\Exports;

use App\Http\Services\PrediccionService;
use App\Models\Preccion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PronosticosExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    protected PrediccionService $prediccionService;

    public function __construct(
        protected string $search = ''
    ) {
        $this->prediccionService = app(PrediccionService::class);
    }

    public function query()
    {
        return Preccion::with([
            'user.country',
            'user.type',
            'user.company',
            'user.visitor',
            'partido.jornada',
            'partido.equipos.equipoUno',
            'partido.equipos.equipoDos',
            'resultado',
        ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($u) {
                        $u->where('nombres', 'like', "%{$this->search}%")
                            ->orWhere('apellidos', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%")
                            ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$this->search}%"]);
                    })
                        ->orWhereHas('user.country', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('user.type', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('user.company', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('user.visitor', fn($q) => $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%{$this->search}%"]))
                        ->orWhereHas('partido.jornada', fn($j) => $j->where('name', 'like', "%{$this->search}%"));
                });
            })
            ->orderBy('created_at', 'desc');
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headings(): array
    {
        return [
            '#',
            'Usuario',
            'Correo Electrónico',
            'No. Documento',
            'Teléfono',
            'Dirección',
            'Colegiado',
            'País',
            'Tipo',
            'Cadena',
            'Visitador',
            'Región',
            'Farmacia',
            'Partido',
            'Jornada',
            'Fecha Partido',
            'Fecha Registro',
            'Última Actualización',
            'Pronóstico',
            'Resultado Real',
            'Puntos',
            'Estado',
        ];
    }

    public function map($p): array
    {
        $equipos = $p->partido?->equipos;
        $e1 = $equipos?->equipoUno?->nombre ?? '?';
        $e2 = $equipos?->equipoDos?->nombre ?? '?';
        $partido = $equipos ? "{$e1} VS {$e2}" : 'N/A';

        $resultado = $p->resultado
            ? $p->resultado->goles_equipo_1 . ' - ' . $p->resultado->goles_equipo_2
            : 'Sin resultado';

        $pts = $this->prediccionService->getResultadoPrediccion($p, $p->resultado);

        return [
            $p->id,
            $p->user->nombres . ' ' . $p->user->apellidos,
            $p->user->email,
            $p->user->numero_documento ?? 'N/A',
            $p->user->telefono ?? 'N/A',
            $p->user->direccion ?? 'N/A',
            $p->user->colegiado ?? 'N/A',
            $p->user->country?->name ?? 'N/A',
            $p->user->type?->name ?? 'N/A',
            $p->user->company?->name ?? 'N/A',
            $p->user->visitor ? $p->user->visitor->name . ' ' . $p->user->visitor->lastname : 'N/A',
            $p->user->region ?? 'N/A',
            $p->user->branch ?? 'N/A',
            $partido,
            $p->partido?->jornada ? 'Jornada ' . $p->partido->jornada->name : 'N/A',
            $p->partido?->fecha_partido?->timezone('America/Guatemala')->format('d/m/Y H:i') ?? 'N/A',
            $p->created_at->timezone('America/Guatemala')->format('d/m/Y H:i'),
            $p->updated_at->timezone('America/Guatemala')->format('d/m/Y H:i'),
            $p->goles_equipo_1 . ' - ' . $p->goles_equipo_2,
            $resultado,
            $pts,
            $p->status === 1 ? 'Puntos acreditados' : 'Pendiente de procesar',
        ];
    }
}
