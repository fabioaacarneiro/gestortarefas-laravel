{{-- @dd($tasks) --}}
<div class="container mb-3">

    <div class="container container-fluid text-center">

        {{-- <div class="d-flex flex-row justify-content-evenly text-center"> --}}
        <div class="row justify-content-between mb-3 mx-0">
            <div class="col-1 me-3">
                <h4>Tarefas</h4>
            </div>
            <div class="col-2">
                <select name="filter" id="filter" class="form-select">
                    <option value="all" @php echo (!empty($filter) && $filter == 'all') ? 'selected' : '' @endphp>
                        Todos
                    </option>
                    <option value="new" @php echo (!empty($filter) && $filter == 'new') ? 'selected' : '' @endphp>
                        Novas
                    </option>
                    <option value="in_progress"
                        @php echo (!empty($filter) && $filter == 'in_progress') ? 'selected' : '' @endphp>Em
                        progresso</option>
                    <option value="cancelled"
                        @php echo (!empty($filter) && $filter == 'cancelled') ? 'selected' : '' @endphp>
                        Canceladas</option>
                    <option value="completed"
                        @php echo (!empty($filter) && $filter == 'completed') ? 'selected' : '' @endphp>
                        Concluídas</option>
                </select>
            </div>
            <div class="col input-group">
                <input type="text" name="text_search" id="text_search" class="form-control" placeholder="Pesquisar">
                <button class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new_task"><i
                        class="bi bi-plus-circle me-2"></i>Nova</button>
                @include('partials.task.form_task', [
                    'route' => 'task.new.submit',
                    'modal_id' => 'new_task',
                    'form_title' => 'Nova Tarefa',
                    'task_id' => '',
                    'task_name' => '',
                    'task_description' => '',
                    'task_status' => '',
                ])
            </div>
        </div>

        {{-- <div class="col text-end">
                    <a href="{{ route('task.new') }}" class="btn btn-primary"><i class="bi bi-plus-square me-2"></i>Nova
                        tarefa</a> --}}

    </div>

    @if (count($tasks) != 0)
        <table class="table table-dark table-striped table-bordered w-100" id="table_tasks">
            <thead class="table-primary">
                <tr>
                    <th class="w-75 ">Tarefas</th>
                    <th class="w-20 text-center">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-light">
                @foreach ($tasks as $task)
                    <tr>
                        <td>
                            <span class="task-title">{{ $task['task_name'] }}</span>
                            <br><small class="opacity-50">{{ $task['task_description'] }}</small>
                        </td>
                        <td class="text-center align-middle">
                            <span class="{{ $task['task_status_style'] }}">{{ $task['task_status'] }}</span>
                        </td>
                        <td class="text-center align-middle">
                            {{-- <a href="{{ route('task.edit', ['id' => Crypt::encrypt($task['task_id'])]) }} "
                                        class="btn btn-secondary m-1"><i class="bi bi-pencil-square"></i></a> --}}

                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#edit_task-{{ $task['task_id'] }}"><i class="bi bi-pencil"></i></button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modalDeleteConfirm-{{ $task['task_id'] }}"><i
                                    class="bi bi-trash"></i></button>
                        </td>
                    </tr>

                    {{-- modal delete --}}
                    <div class="modal fade" id="modalDeleteConfirm-{{ $task['task_id'] }}" tabindex="-1"
                        aria-labelledby="modalDeleteConfirm-{{ $task['task_id'] }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir tarefa</h1>
                                </div>
                                <div class="modal-body">
                                    <h4 class="text-info">{{ $task['task_name'] }}</h4>
                                    <p class="opacity-50">{{ $task['task_description'] }}</p>
                                    <p class="my-5 text-center">Deseja excluir esta tarefa?</p>

                                    <div class="mt-3 text-center">
                                        <hr>
                                        <a href="{{ route('task.index') }}" class="btn btn-secondary px-5 m-1"><i
                                                class="bi bi-cancel me-2" data-bs-dismiss="modal"></i>Cancelar</a>
                                        <a href="{{ route('task.delete.submit', ['id' => Crypt::encrypt($task['task_id'])]) }}"
                                            class="btn btn-danger m-1"><i class="bi bi-thrash me-2"
                                                data-bs-dismiss="modal"></i>Confirmar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('partials.task.form_task', [
                        'route' => 'task.edit.submit',
                        'modal_id' => 'edit_task-' . $task['task_id'],
                        'form_title' => 'Editar Tarefa',
                        'task_id' => $task['task_id'],
                        'task_name' => $task['task_name'],
                        'task_description' => $task['task_description'],
                        'task_status' => $task['task_status'],
                    ])
                @endforeach

            </tbody>
        </table>
    @else
        <p class="text-center opacity-50 my-5">Não existem tarefas registradas</p>
    @endif
</div>

<script>
    // $(document).ready(function() {
    //     $('#table_tasks').DataTable({
    //         data: @json($tasks),
    //         columns: [{
    //                 data: 'task_name'
    //             },
    //             {
    //                 data: 'task_status',
    //                 className: 'text-center align-middle'
    //             },
    //             {
    //                 data: 'task_actions',
    //                 className: 'text-center align-middle'
    //             },
    //         ]
    //     })
    // })

    const filter = document.querySelector('#filter')

    filter.addEventListener('click', () => {
        window.location.href = `{{ url('/filter') }}/${filter.value}`
    })
</script>
