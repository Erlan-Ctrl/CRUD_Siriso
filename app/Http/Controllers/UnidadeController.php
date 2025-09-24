<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;

class UnidadeController extends Controller
{

    public function index()
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('admin.Unidade', compact('unidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'  => 'required|string|max:255',
            'sigla' => 'nullable|string|max:50',
            'status'=> 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        Unidade::create($data);

        return redirect()->route('unidade.index')->with('success', 'Unidade criada com sucesso.');
    }

    public function edit($id)
    {
        return redirect()->route('unidade.index')->with('edit_id', $id);
    }

    public function update(Request $request, $id)
    {
        $unidade = Unidade::findOrFail($id);

        $data = $request->validate([
            'nome'  => 'required|string|max:255',
            'sigla' => 'nullable|string|max:50',
            'status'=> 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        $unidade->update($data);

        return redirect()->route('unidade.index')->with('success', 'Unidade atualizada.');
    }

    public function destroy($id)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->delete();

        return redirect()->route('unidade.index')->with('success', 'Unidade excluída.');
    }
}
