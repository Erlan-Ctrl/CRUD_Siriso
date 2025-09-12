<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unidade;

class UnidadeController extends Controller
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
            'status'=> 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        Unidade::create($data);

        return redirect()->route('admin.entidades')->with('success', 'Unidade criada com sucesso.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.entidades');
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

        return redirect()->route('admin.entidades')->with('success', 'Unidade atualizada.');
    }

    public function destroy($id)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->delete();

        return redirect()->route('admin.entidades')->with('success', 'Unidade excluída.');
    }
}
