<div class="container mb-auto">
    <div class="container-fluid justify-content-center">

        {{-- <div class="col-12 col-lg-5 col-md-6 col-sm-6"> --}}

        @if (isset($list_name))

        <h4 class="text-info"> {{ $list_name }} -
            @if (isset($list_description))
            <em class="text-light">{{ $list_description }}</em>
            @else
            <em class="text-light">Sem descrição</em>
            @endif
        </h4>
        @endif
        {{-- </div> --}}

        <div class="row py-1 mb-3 bg-dark shadow rounded-4">

            <div class="col-12 col-lg-5 col-md-6 col-sm-6">
                <div class="row input-group justify-content-between ms-0 my-2 ">
                    <input type="text" name="text_search" id="text_search" class="col-md form-control " placeholder="Pesquisar">
                    <button type="submit" class="col-auto btn btn-outline-primary" onclick="searchTasks()"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <div class="col-12 col-lg-5 col-md-3 col-sm-3">
                <select name="filter" id="filter" class="form-select my-2">
                    <option value="all" @php echo (!empty($filter) && $filter=='all' ) ? 'selected' : '' @endphp>
                        Todos
                    </option>
                    <option value="new" @php echo (!empty($filter) && $filter=='new' ) ? 'selected' : '' @endphp>
                        Novas
                    </option>
                    <option value="in_progress" @php echo (!empty($filter) && $filter=='in_progress' ) ? 'selected' : '' @endphp>Em progresso
                    </option>
                    <option value="cancelled" @php echo (!empty($filter) && $filter=='cancelled' ) ? 'selected' : '' @endphp>Canceladas
                    </option>
                    <option value="completed" @php echo (!empty($filter) && $filter=='completed' ) ? 'selected' : '' @endphp>Concluídas
                    </option>
                </select>
            </div>

            <div class="col-12 col-lg-2 col-md-3 col-sm-3">
                <button type="button" class="btn btn-outline-info my-2 w-100" data-bs-toggle="modal" data-bs-target="#new_task">
                    <i class="bi bi-plus-circle"></i>
                    <span class="hidden-md">Nova</span>
                </button>

                @include('partials.tasklist.form_task', [
                'route' => 'taskWithList.new',
                'modal_id' => 'new_task',
                'form_title' => 'Nova Tarefa',
                'id' => '',
                'list_id' => $list_id,
                'task_id' => '',
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
                <th class="w-100 px-3 text-center">Tarefas</th>
                <th class="w-auto px-3 text-center">Status</th>
                <th class="w-auto px-3 text-center">Opções</th>
            </tr>
        </thead>
        <tbody class="text-light table-group-divider">
            @foreach ($tasks as $task)
            <tr>
                <td class="p-1">
                    <p class="m-2 mb-0 task-title" title="Título da tarefa.">{{ $task['name'] }}</p>
                    <p class="m-2 mt-0 opacity-75" title="Descrição da tarefa.">{{ $task['description'] }}</p>
                </td>
                <td class="text-center align-middle p-0">
                    <span class="mx-2 {{ $task['status_style'] }} fs-6 shadow shadow-md">{{ $task['status'] }}</span>
                </td>
                <td class="align-middle text-center px-auto">
                    <span class="mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav-{{ $task['id'] }}" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-list fs-2"></i>
                    </span>
                    <div class="collapse p-0 m-0" id="navbarNav-{{ $task['id'] }}">
                        {{-- commentary button --}}
                        <hr class="w-50 mx-auto mt-0 mb-3">
                        <a class="btn btn-primary shadow shadow-md" title="Comentários" data-bs-toggle="modal" data-bs-target="#modalCommentary-{{ $task['id'] }}"><i class="bi bi-chat-right-dots-fill"></i></a>

                        {{-- edit button --}}
                        <a class="btn btn-secondary shadow shadow-md my-3" title="Editar" data-bs-toggle="modal" data-bs-target="#edit_task-{{ $task['id'] }}"><i class="bi bi-pencil"></i></a>

                        {{-- delete button --}}
                        <a class="btn btn-danger shadow shadow-md mb-2" title="Excluir" data-bs-toggle="modal" data-bs-target="#modalDeleteConfirm-{{ $task['id'] }}"><i class="bi bi-trash"></i></a>
                    </div>
                </td>
            </tr>

            {{-- modal commentary --}}
            <div class="modal fade" id="modalCommentary-{{ $task['id'] }}" tabindex="-1" aria-labelledby="modalCommentary-{{ $task['id'] }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h2 class="modal-title fs-5 text-info" id="exampleModalLabel">{{ $task['name'] }}
                            </h2>
                        </div>

                        <div class="modal-body">
                            <form action="{{ route('task.setCommentary', $task['id']) }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $task['id'] }}">

                                <textarea name="commentary" id="commentary" style="height: 250px" class="form-control" placeholder="Escreva um comentário para a tarefa">{{ old('commentary', $task['commentary']) }}</textarea>

                                <hr class="mt-3 w-100">

                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-secondary shadow shadow-md mx-2" data-bs-dismiss="modal" title="Clique para cancelar as alterações nos comentários">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success shadow shadow-md" title="Clique para adicionar o comentário nesta tarefa" data-bs-dismiss="modal">
                                        <i class="bi bi-chat-dots me-2"></i>Adicionar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal delete --}}
            <div class="modal fade" id="modalDeleteConfirm-{{ $task['id'] }}" tabindex="-1" aria-labelledby="modalDeleteConfirm-{{ $task['id'] }}" aria-hidden="true">
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
                            <a href="{{ route('taskWithList.show', $list_id) }}" title="Clique para cancelar as alterações nos comentários" class="btn btn-secondary shadow shadow-md" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Cancelar</a>

                            <a href="{{ route('taskWithList.delete', [$list_id, $task['id']]) }}" class="btn btn-danger shadow shadow-md" title="Clique para confirmar a exclusão desta tarefa">
                                <i class="bi bi-trash me-2"></i>Confirmar</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- inlcude modal edit --}}
            @include('partials.tasklist.form_task', [
            'route' => 'taskWithList.edit',
            'modal_id' => 'edit_task-' . $task['id'],
            'form_title' => 'Editar Tarefa',
            'list_id' => $list_id,
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
        window.location.href = `/tasklist/{{ $list_id }}/filter/${filter.value}`
    })

    const searchTasks = () => {
        const inputSearch = document.querySelector('#text_search')
        window.location.href = `/tasklist/{{ $list_id }}/search/${inputSearch.value}`
    }
</script>
