@extends('templates.main_layout')
@section('content')
    @include('partials.main.nav')
    @if (isset($tasks))
        <div class="container mb-auto">

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
                            data-bs-target="#new_task">
                            <i class="bi bi-plus-circle"></i>
                            <span class="hidden-md">Nova</span>
                        </button>

                        @include('partials.task.form_task', [
                            'route' => 'task.new',
                            'modal_id' => 'new_task',
                            'form_title' => 'Nova Tarefas',
                            'id' => '',
                            'name' => '',
                            'description' => '',
                        ])
                    </div>
                </div>

            </div>

            <div class="row m-2 align-items-center">
                @foreach ($tasks as $task)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card p-3 text-center shadow-md justify-content-between my-3">
                            <h5 class="card-title text-info my-2">{{ $task['name'] }}</h5>
                            <p class="card-text m-2 text-wrap">{{ $task['description'] }}
                            </p>
                            <div class="container-fluid">
                                <div class="row py-2 text-center mt-2">
                                    <div class="col-4 p-0">
                                        {{-- button to edit a tasks  --}}
                                        <button class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#edit_task-{{ $task['id'] }}" title="Editar a a de tarefas."><i
                                                class="bi
                                                bi-pencil text-dark"></i>
                                        </button>
                                        @include('partials.task.form_task', [
                                            'route' => 'task.edit',
                                            'modal_id' => 'edit_task-' . $task['id'],
                                            'form_title' => 'Editando a a de Tarefas',
                                            'id' => $task['id'],
                                            'name' => $task['name'],
                                            'description' => $task['description'],
                                        ])
                                    </div>
                                    <div class="col-4 p-0">
                                        <a href="{{ route('task.index', $task['id']) }}" class="btn btn-success" title="Visualizar a de tarefas."><i
                                                class="bi bi-eye text-dark"></i></a>
                                    </div>
                                    <div class="col-4 p-0">
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteConfirm-{{ $task['id'] }}" title="Deletar a a de tarefas."><i
                                                class="bi bi-trash text-dark"></i></button>
                                    </div>
                                    {{-- modal delete --}}
                                    <div class="modal fade" id="modalDeleteConfirm-{{ $task['id'] }}" tabindex="-1"
                                        aria-labelledby="modalDeleteConfirm-{{ $task['id'] }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir a de
                                                        Tarefas</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 class="text-info">{{ $task['name'] }}</h4>
                                                    <p class="opacity-50">{{ $task['description'] }}</p>
                                                    <p class="mt-5 text-center">Deseja excluir esta Tarefas?</p>
                                                    <p class="mt-5 text-center text-warning">A tarefa será perdida para sempre!</p>

                                                    <div class="row mt-3 text-center">
                                                        <hr>
                                                        <div class="col">
                                                            <button class="btn btn-secondary font shadow shadow-md"
                                                                data-bs-dismiss="modal"><i class="bi bi-cancel me-2"
                                                                    data-bs-dismiss="modal"></i>Cancelar</button>
                                                        </div>
                                                        <div class="col">
                                                            <a href="{{ route('task.delete', $task['id']) }}"
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
        const searchTasks = () => {
            const inputSearch = document.querySelector('#text_search')
            window.location.href = `/task/search/${inputSearch.value}`
        }
    </script>
@endsection
