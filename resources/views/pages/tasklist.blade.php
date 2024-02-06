@extends('templates.main_layout')
@section('content')
    @include('partials.main.nav')
    @if (isset($tasklists))
        <div class="container">

            <div class="container-fluid p-3 m-3">
                <div class="row input-group justify-content-center py-3">

                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <div class="row input-group m-0">
                            <input type="text" name="text_search" id="text_search" class="col form-control"
                                placeholder="Pesquisar">
                            <button type="submit" class="col-auto btn btn-outline-primary" onclick="searchTasklists()"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <div class="col-12 col-sm-10 col-md-2 col-lg-2">
                        <button type="button" class="btn btn-outline-info w-100" data-bs-toggle="modal"
                            data-bs-target="#new_tasklist">
                            <i class="bi bi-plus-circle"></i>
                            <span class="hidden-md">Nova</span>
                        </button>

                        @include('partials.tasklist.form_tasklist', [
                            'route' => 'tasklist.new',
                            'modal_id' => 'new_tasklist',
                            'form_title' => 'Nova Lista de Tarefas',
                            'id' => '',
                            'name' => '',
                            'description' => '',
                        ])
                    </div>
                </div>

            </div>

            <div class="row m-2 align-items-center">
                @foreach ($tasklists as $tasklist)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card p-3 text-center shadow-md justify-content-between my-3">
                            <h5 class="card-title text-info my-2">{{ $tasklist['name'] }}</h5>
                            <p class="card-text m-2 text-wrap">{{ $tasklist['description'] }}
                            </p>
                            <div class="container-fluid">
                                <div class="row py-2 text-center mt-2">
                                    <div class="col-4 p-0">
                                        {{-- button to edit a tasks list --}}
                                        <button class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#edit_tasklist-{{ $tasklist['id'] }}" title="Editar a lista de tarefas."><i
                                                class="bi
                                            bi-pencil text-dark"></i>
                                        </button>
                                    </div>
                                    <div class="col-4 p-0">
                                        <a href="{{ route('task.index', $tasklist['id']) }}" class="btn btn-success" title="Visualizar lista de tarefas."><i
                                                class="bi bi-eye text-dark"></i></a>
                                    </div>
                                    <div class="col-4 p-0">
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteConfirm-{{ $tasklist['id'] }}" title="Deletar a lista de tarefas."><i
                                                class="bi bi-trash text-dark"></i></button>
                                    </div>
                                    {{-- modal delete --}}
                                    <div class="modal fade" id="modalDeleteConfirm-{{ $tasklist['id'] }}" tabindex="-1"
                                        aria-labelledby="modalDeleteConfirm-{{ $tasklist['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir Lista de
                                                        Tarefas</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class="text-info">{{ $tasklist['name'] }}</h4>
                                                    <p class="opacity-50">{{ $tasklist['description'] }}</p>
                                                    <p class="mt-5 text-center">Deseja excluir esta Lista de Tarefas?</p>
                                                    <p class="mt-5 text-center text-warning">Todas as tarefas dentro desta
                                                        lista serão perdidas para sempre!</p>

                                                    <div class="row mt-3 text-center">
                                                        <hr>
                                                        <div class="col">
                                                            <button class="btn btn-secondary font shadow shadow-md"
                                                                data-bs-dismiss="modal"><i class="bi bi-cancel me-2"
                                                                    data-bs-dismiss="modal"></i>Cancelar</button>
                                                        </div>
                                                        <div class="col">
                                                            <a href="{{ route('tasklist.delete', $tasklist['id']) }}"
                                                                class="btn btn-danger shadow shadow-md"><i
                                                                    class="bi bi-thrash me-2"
                                                                    data-bs-dismiss="modal"></i>Confirmar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('partials.tasklist.form_tasklist', [
                        'route' => 'tasklist.edit',
                        'modal_id' => 'edit_tasklist-' . $tasklist['id'],
                        'form_title' => 'Editando a Lista de Tarefas',
                        'id' => $tasklist['id'],
                        'name' => $tasklist['name'],
                        'description' => $tasklist['description'],
                    ])
                @endforeach
            </div>
        </div>
    @endif
    @include('partials.main.footer')
    <script>
        const searchTasklists = () => {
            const inputSearch = document.querySelector('#text_search')
            window.location.href = `/tasklist/search/${inputSearch.value}`
        }
    </script>
@endsection
