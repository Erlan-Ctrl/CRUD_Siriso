@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header"><strong>Novo Funcionário</strong></div>
            <div class="card-body">
                <form action="{{ route('funcionario.store') }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required value="{{ old('nome') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Matrícula</label>
                            <input type="text" name="matricula" class="form-control" value="{{ old('matricula') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Data Nasc.</label>
                            <input type="date" name="dt_nascimento" class="form-control" value="{{ old('dt_nascimento') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Sexo</label>
                            <select name="sexo" class="form-select">
                                <option value="">--</option>
                                <option value="M" {{ old('sexo')=='M'?'selected':'' }}>M</option>
                                <option value="F" {{ old('sexo')=='F'?'selected':'' }}>F</option>
                                <option value="O" {{ old('sexo')=='O'?'selected':'' }}>O</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Cargo</label>
                            <select name="cargo_id" class="form-select">
                                <option value="">--</option>
                                @foreach($cargos as $c)
                                    <option value="{{ $c->id }}" {{ old('cargo_id') == $c->id ? 'selected' : '' }}>{{ $c->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Unidade</label>
                            <select name="unidade_id" class="form-select">
                                <option value="">--</option>
                                @foreach($unidades as $u)
                                    <option value="{{ $u->id }}" {{ old('unidade_id') == $u->id ? 'selected' : '' }}>{{ $u->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success w-100">Salvar Funcionário</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header"><strong>Lista de Funcionários</strong></div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped align-middle" id="tableFuncionarios">
                    <thead class="table-light">
                    <tr><th>ID</th><th>Nome</th><th>Matrícula</th><th>Email</th><th>Cargo</th><th>Unidade</th><th>Ações</th></tr>
                    </thead>
                    <tbody>
                    @foreach($funcionarios as $f)
                        <tr>
                            <td>{{ $f->id }}</td>
                            <td class="col-nome">{{ $f->nome }}</td>
                            <td>{{ $f->matricula }}</td>
                            <td>{{ $f->email }}</td>
                            <td>{{ optional($f->cargo)->nome }}</td>
                            <td>{{ optional($f->unidade)->nome }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary btn-edit-func"
                                        data-id="{{ $f->id }}"
                                        data-nome="{{ $f->nome }}"
                                        data-matricula="{{ $f->matricula }}"
                                        data-dt="{{ $f->dt_nascimento }}"
                                        data-sexo="{{ $f->sexo }}"
                                        data-email="{{ $f->email }}"
                                        data-cargo="{{ $f->cargo_id }}"
                                        data-unidade="{{ $f->unidade_id }}">Editar</button>

                                <form action="{{ route('funcionario.destroy', $f->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir funcionário #{{ $f->id }}?')">
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

    <div class="modal fade" id="modalEditFunc" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditFunc" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Funcionário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Nome</label>
                                <input id="f_nome" type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Matrícula</label>
                                <input id="f_matricula" type="text" name="matricula" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Data Nasc.</label>
                                <input id="f_dt" type="date" name="dt_nascimento" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sexo</label>
                                <select id="f_sexo" name="sexo" class="form-select">
                                    <option value="">--</option>
                                    <option value="M">M</option>
                                    <option value="F">F</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input id="f_email" type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Cargo</label>
                                <select id="f_cargo" name="cargo_id" class="form-select">
                                    <option value="">--</option>
                                    @foreach($cargos as $c)
                                        <option value="{{ $c->id }}">{{ $c->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Unidade</label>
                                <select id="f_unidade" name="unidade_id" class="form-select">
                                    <option value="">--</option>
                                    @foreach($unidades as $u)
                                        <option value="{{ $u->id }}">{{ $u->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modalFuncEl = document.getElementById('modalEditFunc');
        let modalFunc;
        document.addEventListener('DOMContentLoaded', () => {
            modalFunc = new bootstrap.Modal(modalFuncEl);
            document.querySelectorAll('.btn-edit-func').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    document.getElementById('f_nome').value = btn.dataset.nome || '';
                    document.getElementById('f_matricula').value = btn.dataset.matricula || '';
                    document.getElementById('f_dt').value = btn.dataset.dt || '';
                    document.getElementById('f_sexo').value = btn.dataset.sexo || '';
                    document.getElementById('f_email').value = btn.dataset.email || '';
                    document.getElementById('f_cargo').value = btn.dataset.cargo || '';
                    document.getElementById('f_unidade').value = btn.dataset.unidade || '';
                    document.getElementById('formEditFunc').action = '{{ url('funcionario') }}/' + id;
                    modalFunc.show();
                });
            });

            @if(session('edit_id') && $errors->any())
            (function(){
                const id = @json(session('edit_id'));
                document.getElementById('f_nome').value = @json(old('nome'));
                document.getElementById('f_matricula').value = @json(old('matricula'));
                document.getElementById('f_dt').value = @json(old('dt_nascimento'));
                document.getElementById('f_sexo').value = @json(old('sexo'));
                document.getElementById('f_email').value = @json(old('email'));
                document.getElementById('f_cargo').value = @json(old('cargo_id'));
                document.getElementById('f_unidade').value = @json(old('unidade_id'));
                document.getElementById('formEditFunc').action = '{{ url('funcionario') }}/' + id;
                modalFunc.show();
            })();
            @endif
        });
    </script>
@endsection
