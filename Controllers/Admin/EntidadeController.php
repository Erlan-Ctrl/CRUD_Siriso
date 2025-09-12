<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Unidade;
use App\Models\Funcionario;

class EntidadeController extends Controller
{
    public function index()
    {
        $cargos = Cargo::withTrashed()->get();
        $unidades = Unidade::withTrashed()->get();
        $funcionarios = Funcionario::with(['cargo','unidade'])->withTrashed()->get();

        return view('admin.entidades', compact('cargos','unidades','funcionarios'));
    }
}
