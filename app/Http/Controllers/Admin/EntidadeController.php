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
        $cargos= Cargo::orderBy('nome')->get();
        $unidades= Unidade::orderBy('nome')->get();
        $funcionarios= Funcionario::with(['cargo', 'unidade'])->orderBy('created_at', 'desc')->get();

        return view('EscolherCFU', compact('cargos','unidades','funcionarios'));
    }
}
