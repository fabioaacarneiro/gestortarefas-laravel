{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-info">{{ $list->name }}</h4>
            </div>
            <div class="p-3 modal-body">
                <ul class="list-group">
                    @if (isset($list->description))
                        <li class="list-group-item"><b class="text-info">Descrição: </b>{{ $list->description }}</li>
                    @endif
                    @if (isset($list->new))
                        <li class="list-group-item"><b class="text-info">Tarefas novas: </b>{{ $list->new }}
                        </li>
                    @endif
                    @if (isset($list->in_progress))
                        <li class="list-group-item"><b class="text-info">Tarefas em progresso:
                            </b>{{ $list->in_progress }}
                        </li>
                    @endif
                    @if (isset($list->cancelled))
                        <li class="list-group-item"><b class="text-info">Tarefas canceladas:
                            </b>{{ $list->cancelled }}
                        </li>
                    @endif
                    @if (isset($list->completed))
                        <li class="list-group-item"><b class="text-info">Tarefas completas:
                            </b>{{ $list->completed }}
                        </li>
                    @endif
                    @if (isset($list->total))
                        <li class="list-group-item"><b class="text-info">Total de tarefas:
                            </b>{{ $list->total }}
                        </li>
                    @endif
                    <li class="list-group-item"><b class="text-info">Data de criação: </b>{{ $list->created_at }}</li>
                    <li class="list-group-item"><b class="text-info">Ultima atualização: </b>{{ $list->updated_at }}
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal"
                    title="Clique aqui para fechar o resumo da tarefa."><i
                        class="bi bi-x-circle me-2"></i>Fechar</button>

                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edit_tasklist-{{ $list['id'] }}"
                    title="Editar esta lista de tarefas."><i class="bi bi-pencil me-2"></i>Editar
                </button>
                <a href="{{ route('taskWithList.search', $list['id']) }}" class="btn btn-success"
                    title="Visualizar lista de tarefas."><i class="bi bi-arrow-right-circle me-2"></i>Acessar a
                    Lista</a>
            </div>
        </div>
    </div>
</div>

@include('partials.tasklist.form_tasklist', [
    'route' => 'tasklist.edit',
    'modal_id' => 'edit_tasklist-' . $list['id'],
    'form_title' => 'Editando a Lista de Tarefas',
    'list_id' => $list['id'],
    'list_name' => $list['name'],
    'description' => $list['description'],
])
