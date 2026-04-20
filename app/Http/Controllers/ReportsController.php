<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function report() {
        return view('modulos.admin.dashboard');
    }
}
