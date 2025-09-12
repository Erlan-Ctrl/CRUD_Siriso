<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.entidades');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:50',
            'dt_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F,O',
            'email' => 'nullable|email|max:255',
            'cargo_id' => 'nullable|exists:cargos,id',
            'unidade_id' => 'nullable|exists:unidades,id',
        ]);

        \App\Models\Funcionario::create($data);

        return redirect()->route('admin.entidades')->with('success', 'Funcionário criado.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.entidades');
    }

    public function update(Request $request, $id)
    {
        $func = Funcionario::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:50',
            'dt_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F,O',
            'email' => 'nullable|email|max:255',
            'cargo_id' => 'nullable|exists:cargos,id',
            'unidade_id' => 'nullable|exists:unidades,id',
        ]);

        $func->update($data);

        return redirect()->route('admin.entidades')->with('success', 'Funcionário atualizado.');
    }

    public function destroy($id)
    {
        $func = Funcionario::findOrFail($id);
        $func->delete();

        return redirect()->route('admin.entidades')->with('success', 'Funcionário excluído.');
    }
}
