{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-info">{{ $task->name }}</h4>
            </div>
            <div class="p-3 modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><b class="text-info">Status:
                        </b>{{ translateStatus($task->status) }}
                    </li>
                    @if (isset($task->description))
                        <li class="list-group-item"><b class="text-info">Descrição: </b>{{ $task->description }}</li>
                    @endif
                    @if (isset($task->commentary))
                        <li class="list-group-item"><b class="text-info">Comentários: </b>{{ $task->commentary }}</li>
                    @endif
                    @if ($task->list_id === null)
                        <li class="list-group-item"><b class="text-info">Lista: </b>Sem lista.</li>
                    @endif
                    <li class="list-group-item"><b class="text-info">Data de criação: </b>{{ $task->created_at }}</li>
                    <li class="list-group-item"><b class="text-info">Ultima atualização: </b>{{ $task->updated_at }}
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal"
                    title="Clique aqui para fechar o resumo da tarefa."><i
                        class="bi bi-x-circle me-2"></i>Fechar</button>

                <a class="shadow shadow-md btn btn-info ms-2" title="Editar"
                    data-bs-target="#edit_task-{{ $task->id }}" data-bs-toggle="modal"><i
                        class="bi bi-pencil me-2"></i>Editar tarefa</a>
            </div>
        </div>
    </div>
</div>

@include('partials.task.form_task', [
    'route' => 'task.edit',
    'modal_id' => 'edit_task-' . $task->id,
    'form_title' => 'Editar Tarefa',
    'task_id' => $task->id,
    'name' => $task->name,
    'description' => $task->description,
    'status' => $task->status,
    'type' => 'edit',
])
