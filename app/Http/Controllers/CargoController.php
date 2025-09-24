<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::orderBy('id', 'desc')->paginate(12);
        return view('/admin/Cargo', compact('cargos'));
    }

    public function create()
    {
        return view('cargo.create');
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

        return redirect()->route('cargo.index')->with('success', 'Cargo criado com sucesso.');
    }

    public function edit($id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('cargo.edit', compact('cargo'));
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

        return redirect()->route('cargo.index')->with('success', 'Cargo atualizado.');
    }

    public function destroy($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->delete();

        return redirect()->route('cargo.index')->with('success', 'Cargo excluído.');
    }
}
