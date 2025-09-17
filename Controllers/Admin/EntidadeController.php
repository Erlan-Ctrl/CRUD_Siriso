<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Models\Cargo;
use App\Models\Unidade;
use App\Models\Funcionario;

class EntidadeController extends Controller
{
    protected $map = [
        'cargo' => Cargo::class,
        'unidade' => Unidade::class,
        'funcionario' => Funcionario::class,
    ];

    public function index()
    {
        $cargos = Cargo::orderBy('nome')->get();
        $unidades = Unidade::orderBy('nome')->get();
        $funcionarios = Funcionario::with(['cargo','unidade'])->orderBy('created_at','desc')->get();


        return view('admin.entidades', compact('cargos','unidades','funcionarios'));
    }

    public function store(Request $request)
    {
        $entity = $request->input('entity');

        if (!isset($this->map[$entity])) {
            return $this->badRequest("Entidade inválida: {$entity}");
        }

        switch ($entity) {
            case 'cargo':
                $rules = [
                    'nome' => 'required|string|max:255',
                    'sigla' => 'nullable|string|max:50',
                    'status' => 'nullable|boolean',
                ];
                $data = $this->validateAndPrepare($request, $rules);
                $data['status'] = !empty($data['status']) ? 1 : 0;
                $item = Cargo::create($data);
                return $this->jsonCreated($item);

            case 'unidade':
                $rules = [
                    'nome' => 'required|string|max:255',
                    'sigla' => 'nullable|string|max:50',
                    'status' => 'nullable|boolean',
                ];
                $data = $this->validateAndPrepare($request, $rules);
                $data['status'] = !empty($data['status']) ? 1 : 0;
                $item = Unidade::create($data);
                return $this->jsonCreated($item);

            case 'funcionario':
                $cargoTable = (new Cargo)->getTable();
                $unidadeTable = (new Unidade)->getTable();

                $rules = [
                    'nome' => 'required|string|max:255',
                    'matricula' => 'nullable|string|max:50',
                    'dt_nascimento' => 'nullable|date',
                    'sexo' => ['nullable', Rule::in(['M','F','O'])],
                    'email' => 'nullable|email|max:255',
                    'cargo_id' => "nullable|exists:{$cargoTable},id",
                    'unidade_id' => "nullable|exists:{$unidadeTable},id",
                    'status' => 'nullable|string|in:ativo,inativo',
                ];
                $data = $this->validateAndPrepare($request, $rules);
                $data['status'] = $data['status'] ?? 'ativo';
                $item = Funcionario::create($data);
                $item->load('cargo','unidade');
                return $this->jsonCreated($item);
        }
    }

    public function show($entity, $id)
    {
        if (!isset($this->map[$entity])) {
            return $this->badRequest("Entidade inválida: {$entity}");
        }

        $model = $this->map[$entity];
        $query = $model::query();

        if ($entity === 'funcionario') {
            $query = $query->with('cargo','unidade');
        }

        $item = $query->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $entity, $id)
    {
        if (!isset($this->map[$entity])) {
            return $this->badRequest("Entidade inválida: {$entity}");
        }

        $model = $this->map[$entity];
        $item = $model::findOrFail($id);

        switch ($entity) {
            case 'cargo':
            case 'unidade':
                $rules = [
                    'nome' => 'required|string|max:255',
                    'sigla' => 'nullable|string|max:50',
                    'status' => 'nullable|boolean',
                ];
                $data = $this->validateAndPrepare($request, $rules);
                $data['status'] = !empty($data['status']) ? 1 : 0;
                $item->update($data);
                return response()->json($item);
            case 'funcionario':
                $cargoTable = (new Cargo)->getTable();
                $unidadeTable = (new Unidade)->getTable();
                $rules = [
                    'nome' => 'required|string|max:255',
                    'matricula' => 'nullable|string|max:50',
                    'dt_nascimento' => 'nullable|date',
                    'sexo' => ['nullable', Rule::in(['M','F','O'])],
                    'email' => 'nullable|email|max:255',
                    'cargo_id' => "nullable|exists:{$cargoTable},id",
                    'unidade_id' => "nullable|exists:{$unidadeTable},id",
                    'status' => 'nullable|string|in:ativo,inativo',
                ];
                $data = $this->validateAndPrepare($request, $rules);
                $item->update($data);
                $item->load('cargo','unidade');
                return response()->json($item);
        }
    }


    public function destroy(Request $request, $entity, $id)
    {
        if (!isset($this->map[$entity])) {
            return $this->badRequest("Entidade inválida: {$entity}");
        }

        $model = $this->map[$entity];
        $item = $model::findOrFail($id);
        $item->delete();

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $func = Funcionario::findOrFail($id);
        $func->status = ($func->status === 'ativo') ? 'inativo' : 'ativo';
        $func->save();
        return response()->json(['success' => true, 'status' => $func->status]);
    }


    protected function validateAndPrepare(Request $request, array $rules): array
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dados inválidos',
                'errors' => $validator->errors()
            ], 422)->throwResponse();
        }

        return $validator->validated();
    }

    protected function badRequest(string $message = 'Bad request'): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], 400);
    }

    protected function jsonCreated($item): JsonResponse
    {
        return response()->json($item, 201);
    }
}
