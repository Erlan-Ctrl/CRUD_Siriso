<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Cargos, Unidades e Funcionários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Administração: Cargos • Unidades • Funcionários</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Novo Cargo</div>
                <div class="card-body">
                    <form action="{{ route('cargos.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Sigla</label>
                            <input type="text" name="sigla" class="form-control">
                        </div>
                        <div class="mb-2 form-check">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="cargoStatus">
                            <label class="form-check-label" for="cargoStatus">Ativo</label>
                        </div>
                        <button class="btn btn-primary">Salvar Cargo</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Nova Unidade</div>
                <div class="card-body">
                    <form action="{{ route('unidades.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Sigla</label>
                            <input type="text" name="sigla" class="form-control">
                        </div>
                        <div class="mb-2 form-check">
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="unidadeStatus">
                            <label class="form-check-label" for="unidadeStatus">Ativa</label>
                        </div>
                        <button class="btn btn-primary">Salvar Unidade</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Novo Funcionário</div>
                <div class="card-body">
                    <form action="{{ route('funcionarios.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Matrícula</label>
                            <input type="text" name="matricula" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" name="dt_nascimento" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="M">M</option>
                                <option value="F">F</option>
                                <option value="O">Outro</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Cargo</label>
                            <select name="cargo_id" class="form-select">
                                <option value="">-- selecione --</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{ $cargo->id }}">{{ $cargo->nome }} ({{ $cargo->sigla }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Unidade</label>
                            <select name="unidade_id" class="form-select">
                                <option value="">-- selecione --</option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }} ({{ $unidade->sigla }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success">Salvar Funcionário</button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Cargos</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Sigla</th>
                            <th>Status</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th>deleted_at</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cargos as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td>{{ $c->nome }}</td>
                                <td>{{ $c->sigla }}</td>
                                <td>{{ $c->status ? 'Ativo' : 'Inativo' }}</td>
                                <td>{{ $c->created_at }}</td>
                                <td>{{ $c->updated_at }}</td>
                                <td>{{ $c->deleted_at }}</td>
                                <td>
                                    <a href="{{ route('cargos.edit', $c->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="{{ route('cargos.destroy', $c->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Excluir cargo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Unidades</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Sigla</th>
                            <th>Status</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th>deleted_at</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($unidades as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->nome }}</td>
                                <td>{{ $u->sigla }}</td>
                                <td>{{ $u->status ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $u->created_at }}</td>
                                <td>{{ $u->updated_at }}</td>
                                <td>{{ $u->deleted_at }}</td>
                                <td>
                                    <a href="{{ route('unidades.edit', $u->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="{{ route('unidades.destroy', $u->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Excluir unidade?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Funcionários</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Matrícula</th>
                            <th>Dt Nasc</th>
                            <th>Sexo</th>
                            <th>E-mail</th>
                            <th>Cargo</th>
                            <th>Unidade</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th>deleted_at</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($funcionarios as $f)
                            <tr>
                                <td>{{ $f->id }}</td>
                                <td>{{ $f->nome }}</td>
                                <td>{{ $f->matricula }}</td>
                                <td>{{ optional($f->dt_nascimento)->format('Y-m-d') }}</td>
                                <td>{{ $f->sexo }}</td>
                                <td>{{ $f->email }}</td>
                                <td>{{ optional($f->cargo)->nome }}</td>
                                <td>{{ optional($f->unidade)->nome }}</td>
                                <td>{{ $f->created_at }}</td>
                                <td>{{ $f->updated_at }}</td>
                                <td>{{ $f->deleted_at }}</td>
                                <td>
                                    <a href="{{ route('funcionarios.edit', $f->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="{{ route('funcionarios.destroy', $f->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Excluir funcionário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
