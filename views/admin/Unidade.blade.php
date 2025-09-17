@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header"><strong>Nova Unidade</strong></div>
                    <div class="card-body">
                        <form action="{{ route('unidade.store') }}" method="POST">
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
                                <input type="checkbox" name="status" value="1" class="form-check-input" id="unidadeStatus" {{ old('status',1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="unidadeStatus">Ativa</label>
                            </div>

                            <button class="btn btn-primary w-100">Salvar Unidade</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header"><strong>Unidades</strong></div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-striped align-middle" id="tableUnidades">
                            <thead class="table-light">
                            <tr><th>ID</th><th>Nome</th><th>Sigla</th><th>Status</th><th>Criado</th><th>Atualizado</th><th>Ações</th></tr>
                            </thead>
                            <tbody>
                            @foreach($unidades as $u)
                                <tr data-id="{{ $u->id }}">
                                    <td>{{ $u->id }}</td>
                                    <td class="col-nome">{{ $u->nome }}</td>
                                    <td class="col-sigla">{{ $u->sigla }}</td>
                                    <td class="col-status">{{ $u->status ? 'Ativa' : 'Inativa' }}</td>
                                    <td>{{ $u->created_at }}</td>
                                    <td>{{ $u->updated_at }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-edit-unidade"
                                                data-id="{{ $u->id }}"
                                                data-nome="{{ $u->nome }}"
                                                data-sigla="{{ $u->sigla }}"
                                                data-status="{{ $u->status ? 1 : 0 }}">Editar</button>

                                        <form action="{{ route('unidade.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir unidade #{{ $u->id }}?')">
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

    <div class="modal fade" id="modalEditUnidade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditUnidade" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Unidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Nome</label>
                            <input id="u_nome" type="text" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Sigla</label>
                            <input id="u_sigla" type="text" name="sigla" class="form-control">
                        </div>
                        <div class="mb-3 form-check">
                            <input id="u_status" type="checkbox" name="status" value="1" class="form-check-input">
                            <label class="form-check-label" for="u_status">Ativa</label>
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
        const modalUnidadeEl = document.getElementById('modalEditUnidade');
        let modalUnidade;
        document.addEventListener('DOMContentLoaded', () => {
            modalUnidade = new bootstrap.Modal(modalUnidadeEl);
            document.querySelectorAll('.btn-edit-unidade').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    document.getElementById('u_nome').value = btn.dataset.nome || '';
                    document.getElementById('u_sigla').value = btn.dataset.sigla || '';
                    document.getElementById('u_status').checked = btn.dataset.status == '1';
                    document.getElementById('formEditUnidade').action = '{{ url('unidade') }}/' + id;
                    modalUnidade.show();
                });
            });

            @if(session('edit_id') && $errors->any())
            (function(){
                const id = @json(session('edit_id'));
                document.getElementById('u_nome').value = @json(old('nome'));
                document.getElementById('u_sigla').value = @json(old('sigla'));
                document.getElementById('u_status').checked = @json(old('status')) == 1;
                document.getElementById('formEditUnidade').action = '{{ url('unidade') }}/' + id;
                modalUnidade.show();
            })();
            @endif
        });
    </script>
@endsection
