<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Funcionario;
use App\Models\Cargo;
use App\Models\Unidade;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::with(['cargo','unidade'])->get();
        $cargos = Cargo::all();
        $unidades = Unidade::all();
        return view('admin.Funcionario', compact('funcionarios','cargos','unidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:50',
            'dt_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F,O',
            'email' => 'nullable|email|max:255',
            'cargo_id' => 'nullable|exists:cargo,id',
            'unidade_id' => 'nullable|exists:unidade,id',
        ]);

        Funcionario::create($data);

        return redirect()->route('funcionario.index')->with('success', 'Funcionário criado.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'matricula' => 'nullable|string|max:50',
            'dt_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F,O',
            'email' => 'nullable|email|max:255',
            'cargo_id' => 'nullable|exists:cargo,id',
            'unidade_id' => 'nullable|exists:unidade,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('funcionario.index')
                ->withErrors($validator)
                ->withInput()
                ->with('edit_id', $id);
        }

        $func = Funcionario::findOrFail($id);
        $func->update($validator->validated());

        return redirect()->route('funcionario.index')->with('success', 'Funcionário atualizado.');
    }

    public function destroy($id)
    {
        $func = Funcionario::findOrFail($id);
        $func->delete();
        return redirect()->route('funcionario.index')->with('success', 'Funcionário excluído.');
    }
}
