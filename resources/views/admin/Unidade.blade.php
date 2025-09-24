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
            {{--Quando uma validação do Laravel falha e o usuário é redirecionado de volta ao formulário, esse código mostra todas as mensagens de erro para o usuário.--}}

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
                                <input type="checkbox" name="status" value="1" class="form-check-input"
                                       id="unidadeStatus" {{ old('status',1) ? 'checked' : '' }}>
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
                            @foreach($unidades as $u)
                                <tr data-id="{{ $u->id }}">
                                    <td>{{ $u->id }}</td>
                                    <td class="col-nome">{{ $u->nome }}</td>
                                    <td class="col-sigla">{{ $u->sigla }}</td>
                                    <td class="col-status">{{ $u->status ? 'Ativa' : 'Inativa' }}</td>
                                    <td>{{ $u->created_at ? Carbon::parse($u->created_at)->format('d/m/Y') : '' }}</td>
                                    <td>{{ $u->updated_at ? Carbon::parse($u->updated_at)->format('d/m/Y') : '' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-edit-unidade"
                                                data-id="{{ $u->id }}"
                                                data-nome="{{ $u->nome }}"
                                                data-sigla="{{ $u->sigla }}"
                                                data-status="{{ $u->status ? 1 : 0 }}">Editar
                                        </button>

                                        <form action="{{ route('unidade.destroy', $u->id) }}" method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Excluir unidade #{{ $u->id }}?')">
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
        //ANOTAÇÕES
        const modalUnidadeEl = document.getElementById('modalEditUnidade');
        // Procura no DOM o elemento com id modalEditUnidade.
        // Guarda a referência nesse const. Esse é o elemento HTML que representa o modal (geralmente um <div> com a estrutura do Bootstrap).
        // Se não existir elemento com esse id, o valor será null.
        let modalUnidade;
        // Declara uma variável chamada modalUnidade sem inicializá-la.
        // Foi declarada com let para que seja atribuída depois (no carregamento) e fique acessível no escopo externo do DOMContentLoaded (para ser usada pelos handlers).
        document.addEventListener('DOMContentLoaded', () => {
            // Registra um listener para o evento DOMContentLoaded.
            // Esse evento é disparado quando o HTML foi totalmente lido e o DOM está pronto (não espera imagens ou CSS externos).
            // O bloco dentro da arrow function só será executado quando o DOM estiver disponível, evitando null em getElementById se chamado cedo demais.
            modalUnidade = new bootstrap.Modal(modalUnidadeEl);
            // Cria uma instância do modal do Bootstrap 5 associado ao elemento obtido na linha 134.
            // bootstrap.Modal é a API JS do Bootstrap para controlar modais (abrir, fechar, etc.).
            // A instância é atribuída à modalUnidade para que depois possamos chamar modalUnidade.show() ou hide().
            document.querySelectorAll('.btn-edit-unidade').forEach(btn => {
                // Seleciona todos os elementos do DOM com a classe CSS .btn-edit-unidade (botões/links que abrem o modal para editar uma unidade).
                // querySelectorAll retorna um NodeList. forEach itera sobre cada elemento (cada btn).
                btn.addEventListener('click', () => {
                    // Para cada botão, adiciona um listener para o evento click.
                    // Quando o botão for clicado, o callback dentro será executado: ele preenche o formulário do modal e exibe o modal.
                    const id = btn.dataset.id;
                    // Lê o atributo data-id do botão. (Atributos data-xxx ficam acessíveis em JS por element.dataset.xxx.)
                    // Ex.: se o HTML tiver <button data-id="42" ...>, id será "42" (string).
                    document.getElementById('u_nome').value = btn.dataset.nome || '';
                    // Procura o elemento com id u_nome e define seu .value.
                    document.getElementById('u_sigla').value = btn.dataset.sigla || '';
                    // Igual à linha 9, mas para o campo u_sigla e data-sigla. Preenche a sigla no campo do modal.
                    document.getElementById('u_status').checked = btn.dataset.status === '1';
                    // Procura o elemento u_status (provavelmente um checkbox).
                    // Define sua propriedade checked como true ou false dependendo do data-status do botão.
                    // A comparação == '1' verifica se o valor textual é '1'. Se data-status="1", o checkbox fica marcado. Qualquer outro valor resulta em false.
                    document.getElementById('formEditUnidade').action = '{{ url('unidade') }}/' + id;
                    // Procura o elemento <form> com id formEditUnidade e seta seu atributo action (URL onde o formulário será enviado).
                    modalUnidade.show();
                    // Usa a instância do modal do Bootstrap para abrir/exibir o modal.
                });
            });
        });
    </script>
@endsection
