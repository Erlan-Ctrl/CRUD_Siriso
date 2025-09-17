<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siriso - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Administração: Cargos • Unidades • Funcionários</h1>

    <div id="alerts"></div>

    <div class="row">
        <div class="col-md-4">

            <div class="card mb-4">
                <div class="card-header">Novo Cargo</div>
                <div class="card-body">
                    <form id="formCargo">
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
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="cargoStatus" checked>
                            <label class="form-check-label" for="cargoStatus">Ativo</label>
                        </div>
                        <button class="btn btn-primary" type="submit">Salvar Cargo</button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Nova Unidade</div>
                <div class="card-body">
                    <form id="formUnidade">
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
                            <input type="checkbox" name="status" value="1" class="form-check-input" id="unidadeStatus" checked>
                            <label class="form-check-label" for="unidadeStatus">Ativa</label>
                        </div>
                        <button class="btn btn-primary" type="submit">Salvar Unidade</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Novo Funcionário</div>
                <div class="card-body">
                    <form id="formFuncionario">
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
                            <select name="cargo_id" id="selectCargo" class="form-select">
                                <option value="">-- selecione --</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{ $cargo->id }}">{{ $cargo->nome }} ({{ $cargo->sigla }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Unidade</label>
                            <select name="unidade_id" id="selectUnidade" class="form-select">
                                <option value="">-- selecione --</option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }} ({{ $unidade->sigla }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success" type="submit">Salvar Funcionário</button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header">Cargos</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-striped" id="tableCargos">
                        <thead>
                        <tr>
                            <th>ID</th><th>Nome</th><th>Sigla</th><th>Status</th><th>Criado</th><th>Atualizado</th><th>Deletado</th><th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cargos as $c)
                            <tr data-id="{{ $c->id }}">
                                <td class="col-id">{{ $c->id }}</td>
                                <td class="col-nome">{{ $c->nome }}</td>
                                <td class="col-sigla">{{ $c->sigla }}</td>
                                <td class="col-status">{{ $c->status ? 'Ativo' : 'Inativo' }}</td>
                                <td class="col-created">{{ $c->created_at }}</td>
                                <td class="col-updated">{{ $c->updated_at }}</td>
                                <td class="col-deleted">{{ $c->deleted_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btn-edit-cargo">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete-cargo">Excluir</button>
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
                    <table class="table table-sm table-striped" id="tableUnidades">
                        <thead>
                        <tr>
                            <th>ID</th><th>Nome</th><th>Sigla</th><th>Status</th><th>Criado</th><th>Atualizado</th><th>Deletado</th><th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($unidades as $u)
                            <tr data-id="{{ $u->id }}">
                                <td class="col-id">{{ $u->id }}</td>
                                <td class="col-nome">{{ $u->nome }}</td>
                                <td class="col-sigla">{{ $u->sigla }}</td>
                                <td class="col-status">{{ $u->status ? 'Ativa' : 'Inativa' }}</td>
                                <td class="col-created">{{ $u->created_at }}</td>
                                <td class="col-updated">{{ $u->updated_at }}</td>
                                <td class="col-deleted">{{ $u->deleted_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btn-edit-unidade">Editar</button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete-unidade">Excluir</button>
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
                    <table class="table table-sm table-striped" id="tableFuncionarios">
                        <thead>
                        <tr>
                            <th>ID</th><th>Nome</th><th>Matrícula</th><th>Data de Nasc.</th><th>Sexo</th><th>E-mail</th><th>Cargo</th><th>Unidade</th><th>Status</th><th>Criado</th><th>Atualizado</th><th>Deletado</th><th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($funcionarios as $f)
                            <tr data-id="{{ $f->id }}">
                                <td class="col-id">{{ $f->id }}</td>
                                <td class="col-nome">{{ $f->nome }}</td>
                                <td class="col-matricula">{{ $f->matricula }}</td>
                                <td class="col-dt">{{ optional($f->dt_nascimento)->format('d-m-Y') }}</td>
                                <td class="col-sexo">{{ $f->sexo }}</td>
                                <td class="col-email">{{ $f->email }}</td>
                                <td class="col-cargo" data-cargo-id="{{ optional($f->cargo)->id }}">{{ optional($f->cargo)->nome }}</td>
                                <td class="col-unidade" data-unidade-id="{{ optional($f->unidade)->id }}">{{ optional($f->unidade)->nome }}</td>
                                <td class="col-status">{{ $f->status }}</td>
                                <td class="col-created">{{ $f->created_at }}</td>
                                <td class="col-updated">{{ $f->updated_at }}</td>
                                <td class="col-deleted">{{ $f->deleted_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btn-edit-func">Editar</button>
                                    <button class="btn btn-sm btn-outline-warning btn-toggle-status">Alternar status</button>
                                    <button class="btn btn-sm btn-outline-danger btn-delete-func">Excluir</button>
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEdit">
                @csrf
                <input type="hidden" id="edit_entity" name="entity">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
