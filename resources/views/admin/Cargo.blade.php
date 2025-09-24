@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach</ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header"><strong>Novo Cargo</strong></div>
                    <div class="card-body">
                        <form action="{{ route('cargo.store') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Sigla</label>
                                <input type="text" name="sigla" class="form-control" value="{{ old('sigla') }}">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="status" value="1" class="form-check-input"
                                       id="cargoStatus" {{ old('status',1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cargoStatus">Ativo</label>
                            </div>

                            <button class="btn btn-primary w-100">Salvar Cargo</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header"><strong>Cargos</strong></div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped align-middle" id="tableCargos">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Sigla</th>
                                <th>Status</th>
                                <th>Criado</th>
                                <th>Atualizado</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cargos as $c)
                                <tr data-id="{{ $c->id }}">
                                    <td>{{ $c->id }}</td>
                                    <td class="col-nome">{{ $c->nome }}</td>
                                    <td class="col-sigla">{{ $c->sigla }}</td>
                                    <td class="col-status">{{ $c->status ? 'Ativo' : 'Inativo' }}</td>
                                    <td>{{ $c->created_at ? Carbon::parse($c->created_at)->format('d/m/Y') : '' }}</td>
                                    <td>{{ $c->updated_at ? Carbon::parse($c->updated_at)->format('d/m/Y') : ''  }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-edit-cargo"
                                                data-id="{{ $c->id }}"
                                                data-nome="{{ $c->nome }}"
                                                data-sigla="{{ $c->sigla }}"
                                                data-status="{{ $c->status ? 1 : 0 }}">Editar
                                        </button>

                                        <form action="{{ route('cargo.destroy', $c->id) }}" method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Excluir cargo #{{ $c->id }}?')">
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

    <div class="modal fade" id="modalEditCargo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditCargo" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Cargo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Nome</label>
                            <input id="e_nome" type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Sigla</label>
                            <input id="e_sigla" type="text" name="sigla" class="form-control">
                        </div>
                        <div class="mb-3 form-check">
                            <input id="e_status" type="checkbox" name="status" value="1" class="form-check-input">
                            <label class="form-check-label" for="e_status">Ativo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        //ANOTEI NO UNIDADE.BLADE A LÓGICA, AQ É BÁSICAMENTE UMA REPLICA DO UNIDADE
        const modalCargoEl = document.getElementById('modalEditCargo');
        let modalCargo;
        document.addEventListener('DOMContentLoaded', () => {
            modalCargo = new bootstrap.Modal(modalCargoEl);
            document.querySelectorAll('.btn-edit-cargo').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    document.getElementById('e_nome').value = btn.dataset.nome || '';
                    document.getElementById('e_sigla').value = btn.dataset.sigla || '';
                    document.getElementById('e_status').checked = btn.dataset.status === '1';
                    document.getElementById('formEditCargo').action = '{{ url('cargo') }}/' + id;
                    modalCargo.show();
                });
            });
        });
    </script>
@endsection
