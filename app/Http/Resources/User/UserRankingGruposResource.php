<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\Country\CountryUserResource;
use App\Http\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRankingGruposResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $decoracion      = null;
        $color           = '';
        $backgroundColor = '';
        $fontColor       = '';

        switch($this->posicion) {
            case 1:
                $decoracion = HelperService::ImagePath('/images/decoracion/trophy_overlay.png');
                $color = '#FFBF00';
                $backgroundColor = '#d2d4da';
                $fontColor       = '#101820';
                break;

            case 2:
                $color = '#BEBEBE';
                $backgroundColor = '#d2d4da';
                $fontColor       = '#101820';
                break;

            case 3:
                $color = '#A0522D';
                $backgroundColor = '#d2d4da';
                $fontColor       = '#101820';
                break;
                
            default:
                $decoracion = null;
                $color = '#101820';
                $backgroundColor = '#d2d4da';
                $fontColor       = '#101820';
                break;
        }

        $user_timezone = $this->country->timezone;
        $fecha_registro = $this->created_at->timezone($user_timezone);

        return [
            'id'              => $this->id,
            'nombres'         => $this->nombres,
            'apellidos'       => $this->apellidos,
            'puntos'          => $this->puntos_grupos,
            'posicion'        => $this->posicion,
            'pais'            => new CountryUserResource($this->country),
            'color'           => $color,
            'backgroundColor' => $backgroundColor,
            'fontColor'       => $fontColor,
            'decoracion'      => $decoracion,
            'marca'           => $this->brand ? new BrandResource($this->brand) : null,
            'fechaRegistro'   => $fecha_registro->format('Y-m-d H:i:s'),
            'mostrarBandera'  => $this->user_type_id === 3,
        ];
    }
}
