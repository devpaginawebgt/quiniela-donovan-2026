<?php

namespace App\Http\Services;

class TermsService {

    public function getTerms()
    {
        return [
            'version' => '1.0',
            'ultima_actualizacion' => '2026-03-10',

            'titulo' => 'Terminos y condiciones'
        ];
    }

}