<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsuariosExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    public function __construct(
        protected string $search = ''
    ) {}

    public function query()
    {
        return User::with(['country', 'type', 'company', 'visitor', 'pushTokens'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombres', 'like', "%{$this->search}%")
                        ->orWhere('apellidos', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$this->search}%"])
                        ->orWhereHas('country', fn($country) => $country->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('type', fn($type) => $type->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('company', fn($company) => $company->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('visitor', fn($visitor) => $visitor->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%{$this->search}%"]));
                });
            })
            ->orderBy('puntos', 'desc');
    }


    public function chunkSize(): int
    {
        return 1000;
    }


    public function headings(): array
    {
        return [
            '#',
            'Nombres',
            'Apellidos',
            'Correo Electrónico',
            'Teléfono',
            'País',
            'Tipo',
            'Empresa',
            'Visitador',
            'Región',
            'Puntos Trivias',
            'Puntos Predicciones',
            'Puntos Bonus',
            'Puntos Total',
            'Fecha Registro',
            'Estado',
            'Notificaciones',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->nombres,
            $user->apellidos,
            $user->email,
            $user->telefono,
            $user->country?->name ?? 'N/A',
            $user->type?->name ?? 'N/A',
            $user->company?->name ?? 'N/A',
            $user->visitor ? $user->visitor->name . ' ' . $user->visitor->lastname : 'N/A',
            $user->region ?? 'N/A',
            $user->puntos_trivias,
            $user->puntos_predicciones,
            $user->puntos_bonus,
            $user->puntos,
            $user->created_at->format('d/m/Y h:i A'),
            $user->status_user ? 'Activo' : 'Inactivo',
            $user->pushTokens->where('is_active', true)->isNotEmpty() ? 'Sí' : 'No',
        ];
    }
}
