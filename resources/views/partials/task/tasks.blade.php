<div class="container mb-auto">

    <div class="container-fluid justify-content-center">

        <div class="row py-1 mb-3 bg-dark shadow rounded-4">

            <div class="col-12 col-lg-5 col-md-6 col-sm-6">
                <div class="row input-group justify-content-center ms-0 my-2 ">
                    <input type="text" name="text_search" id="text_search" class="col-md form-control "
                        placeholder="Pesquisar">
                    <button type="submit" class="col-auto btn btn-outline-primary" onclick="searchTasks()"><i
                            class="bi bi-search"></i></button>
                </div>
            </div>

            <div class="col-12 col-lg-5 col-md-3 col-sm-3">
                <select name="filter" id="filter" class="form-select my-2">
                    <option value="all" @php echo (!empty($filter) && $filter == 'all') ? 'selected' : '' @endphp>
                        Todos
                    </option>
                    <option value="new" @php echo (!empty($filter) && $filter == 'new') ? 'selected' : '' @endphp>
                        Novas
                    </option>
                    <option value="in_progress"
                        @php echo (!empty($filter) && $filter == 'in_progress') ? 'selected' : '' @endphp>Em progresso
                    </option>
                    <option value="cancelled"
                        @php echo (!empty($filter) && $filter == 'cancelled') ? 'selected' : '' @endphp>Canceladas
                    </option>
                    <option value="completed"
                        @php echo (!empty($filter) && $filter == 'completed') ? 'selected' : '' @endphp>Concluídas
                    </option>
                </select>
            </div>

            <div class="col-12 col-lg-2 col-md-3 col-sm-3">
                <button type="button" class="btn btn-outline-info my-2 w-100" data-bs-toggle="modal"
                    data-bs-target="#new_task">
                    <i class="bi bi-plus-circle"></i>
                    <span class="hidden-md">Nova</span>
                </button>

                @include('partials.task.form_task', [
                    'route' => 'task.new',
                    'modal_id' => 'new_task',
                    'form_title' => 'Nova Tarefa',
                    'task_id' => '',
                    'list_id' => null,
                    'name' => '',
                    'description' => '',
                    'status' => 'new',
                    'type' => 'new',
                ])

            </div>
        </div>
    </div>

    {{-- <div class="col text-end">
                    <a href="{{ route('task.new') }}" class="btn btn-primary"><i class="bi bi-plus-square me-2"></i>Nova
                        tarefa</a> --}}

    @if (count($tasks) != 0)
        <table class="table table-dark table-striped-columns w-100 shadow shadow-md" id="table_tasks">
            <thead class="table-outline-dark">
                <tr>
                    <th class="w-75 text-center">Tarefas</th>
                    <th class="w-20 text-center">Status</th>
                    <th class="text-center">Opções</th>
                </tr>
            </thead>
            <tbody class="text-light table-group-divider">
                @foreach ($tasks as $task)
                    <tr>
                        <td>
                            <p class="task-title" title="Título da tarefa.">{{ $task['name'] }}</p>
                            <p class="opacity-75" title="Descrição da tarefa.">{{ $task['description'] }}</p>
                        </td>
                        <td class="text-center align-middle">
                            <span class="{{ $task['status_style'] }} fs-6 shadow shadow-md">{{ $task['status'] }}</span>
                        </td>
                        <td class="d-flex justify-content-around text-center">
                            <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
                                <div class="mx-auto">
                                    <span class="d-lg-none" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarNav-{{ $task['id'] }}" aria-controls="navbarNav"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <i class="bi bi-list fs-2"></i>
                                    </span>
                                </div>
                                <div class="collapse d-lg-block m-0" id="navbarNav-{{ $task['id'] }}">
                                    {{-- commentary button --}}
                                    <a class="btn btn-primary shadow shadow-md" title="Comentários"
                                        data-bs-toggle="modal" data-bs-target="#modalCommentary-{{ $task['id'] }}"><i
                                            class="bi bi-chat-right-dots-fill"></i></a>

                                    {{-- edit button --}}
                                    <a class="btn btn-secondary shadow shadow-md m-1" title="Editar"
                                        data-bs-toggle="modal" data-bs-target="#edit_task-{{ $task['id'] }}"><i
                                            class="bi bi-pencil"></i></a>

                                    {{-- delete button --}}
                                    <a class="btn btn-danger shadow shadow-md" title="Excluir" data-bs-toggle="modal"
                                        data-bs-target="#modalDeleteConfirm-{{ $task['id'] }}"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </nav>
                        </td>
                    </tr>

                    {{-- modal commentary --}}
                    <div class="modal fade" id="modalCommentary-{{ $task['id'] }}" tabindex="-1"
                        aria-labelledby="modalCommentary-{{ $task['id'] }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content modal-centered">
                                <div class="modal-header">
                                    <h4 class="text-info text-center" title="Título da tarefa">{{ $task['name'] }}</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('task.setCommentary', $task['id']) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $task['id'] }}">

                                        <textarea name="commentary" id="commentary" style="height: 250px" class="form-control"
                                            title="Escreva seus comentários aqui" placeholder="Escreva um comentário para a tarefa">{{ old('commentary', $task['commentary']) }}</textarea>

                                        <hr class="my-3">

                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-secondary shadow shadow-md mx-2"
                                                title="Clique para cancelar as alterações nos comentários"
                                                data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle me-2"></i>Cancelar</button>
                                            <button type="submit" class="btn btn-success shadow shadow-md"
                                                title="Clique para adicionar o comentário nesta tarefa"
                                                data-bs-dismiss="modal" class="bi bi-check me-2">
                                                <i class="bi bi-chat-dots me-2"></i>Adicionar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- modal delete --}}
                    <div class="modal fade" id="modalDeleteConfirm-{{ $task['id'] }}" tabindex="-1"
                        aria-labelledby="modalDeleteConfirm-{{ $task['id'] }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="text-info text-center">{{ $task['name'] }}</h4>
                                </div>
                                <div class="modal-body">
                                    <p class="opacity-50 text-center">{{ $task['description'] }}</p>
                                    <p class="text-center">Deseja excluir esta tarefa?</p>
                                    <p class="text-center text-warning">A tarefa será perdida para sempre!</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary shadow shadow-md mx-2"
                                        title="Clique para cancelar as alterações nos comentários"
                                        data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar</button>

                                    <a href="{{ route('task.delete', $task['id']) }}"
                                        class="btn btn-danger shadow shadow-md"
                                        title="Clique para confirmar a exclusão desta tarefa">
                                        <i class="bi bi-trash me-2"></i>Excluir</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('partials.task.form_task', [
                        'route' => 'task.edit',
                        'modal_id' => 'edit_task-' . $task['id'],
                        'form_title' => 'Editar Tarefa',
                        'task_id' => $task['id'],
                        'name' => $task['name'],
                        'description' => $task['description'],
                        'status' => $task['status'],
                        'type' => 'edit',
                    ])
                @endforeach

            </tbody>
        </table>
    @else
        <p class="text-center opacity-50 my-5">Não existem tarefas registradas</p>
    @endif
</div>

<script>
    const filter = document.querySelector('#filter')

    filter.addEventListener('change', () => {
        window.location.href = `/task/${filter.value}/filter`
    })

    const searchTasks = () => {
        const inputSearch = document.querySelector('#text_search')
        window.location.href = `/task/${inputSearch.value}/search`
    }
</script>
