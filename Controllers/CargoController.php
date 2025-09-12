<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.entidades');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'  => 'required|string|max:255',
            'sigla' => 'nullable|string|max:50',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        Cargo::create($data);

        return redirect()->route('admin.entidades')->with('success', 'Cargo criado com sucesso.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.entidades');
    }

    public function update(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);

        $data = $request->validate([
            'nome'  => 'required|string|max:255',
            'sigla' => 'nullable|string|max:50',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        $cargo->update($data);

        return redirect()->route('admin.entidades')->with('success', 'Cargo atualizado.');
    }

    public function destroy($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->delete();

        return redirect()->route('admin.entidades')->with('success', 'Cargo excluído.');
    }
}
