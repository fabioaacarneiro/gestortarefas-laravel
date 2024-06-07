@extends('templates.main_layout')
@section('content')
    @include('partials.main.nav')
    @if (isset($lists))
        <div class="container mb-auto">

            <div class="container-fluid">
                <div class="row input-group justify-content-center">

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
                            'list_id' => '',
                            'list_name' => '',
                            'description' => '',
                        ])
                    </div>
                </div>

            </div>

            <div class="row align-items-center mt-3">
                @foreach ($lists as $list)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card my-2 p-2 text-center shadow-md justify-content-between" style="height: 10rem">
                            <h5 class="card-title text-info my-2">{{ $list['name'] }}</h5>

                            @if (isset($list['description']))
                                <div class="row d-flex justify-content-center">
                                    <div class="col-8 text-truncate">
                                        {{ $list['description'] }}
                                    </div>
                                </div>
                            @else
                                <p class="card-text m-2 text-light"><em>Sem Descrição</em></p>
                            @endif

                            <div class="container-fluid d-flex justify-content-center mb-2">
                                <div class="row mt-2">
                                    <div class="col-4">
                                        {{-- button to edit a tasks list --}}
                                        <button class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#edit_tasklist-{{ $list['id'] }}"
                                            title="Editar a lista de tarefas."><i
                                                class="bi
                                                bi-pencil text-dark"></i>
                                        </button>
                                        @include('partials.tasklist.form_tasklist', [
                                            'route' => 'tasklist.edit',
                                            'modal_id' => 'edit_tasklist-' . $list['id'],
                                            'form_title' => 'Editando a Lista de Tarefas',
                                            'list_id' => $list['id'],
                                            'list_name' => $list['name'],
                                            'description' => $list['description'],
                                        ])
                                    </div>
                                    <div class="col-4">
                                        {{-- visualizar a lista de tarefas --}}
                                        <a href="{{ route('taskWithList.search', $list['id']) }}" class="btn btn-success"
                                            title="Visualizar lista de tarefas."><i class="bi bi-eye text-dark"></i></a>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteConfirm-{{ $list['id'] }}"
                                            title="Deletar a lista de tarefas."><i
                                                class="bi bi-trash text-dark"></i></button>
                                    </div>
                                    {{-- modal delete --}}
                                    <div class="modal fade" id="modalDeleteConfirm-{{ $list['id'] }}" tabindex="-1"
                                        aria-labelledby="modalDeleteConfirm-{{ $list['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir Lista de
                                                        Tarefas</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class="text-info">{{ $list['name'] }}</h4>
                                                    <p class="opacity-50">{{ $list['description'] }}</p>
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
                                                            <a href="{{ route('tasklist.delete', $list['id']) }}"
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
