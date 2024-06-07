@extends('templates.main_layout')
@section('content')
    @include('partials.main.nav')
    <div class="row mx-2 mb-auto">
        <div class="col col-6">
            <ul class="list-group">
                <li class="text-white list-group-item text-center">
                    <div class="d-flex justify-content-evenly">
                        <b class="text-center mx-auto">Tarefas sem lista</b>
                        <a class="link-underline link-underline-opacity-0 link-opacity-50-hover"
                            href="{{ route('task.show') }}"><em>Acessar</em></a>
                    </div>
                </li>
                @if (sizeof($tasks) > 0)
                    @foreach ($tasks as $task)
                        <li class="text-info list-group-item list-group-item-action" data-bs-toggle="modal"
                            data-bs-target="#task-resume-{{ $task->id }}">
                            <div class="d-flex justify-content-between">
                                <div class="text-info text-start text-truncate col-6">{{ $task->name }}</div>
                                @if (isset($task->description))
                                    <div class="text-white text-truncate col-4 text-end">{{ $task->description }}
                                    </div>
                                @else
                                    <div class="text-light text-end"><em>Sem descrição.</em></div>
                                @endif
                            </div>
                        </li>
                        @include('partials.task.modal_task_resume', [
                            'modal_id' => 'task-resume-' . $task->id,
                            'form_title' => 'Resumo da tarefa',
                            'task' => $task,
                            'edit_modal_id' => 'edit_task-' . $task->id,
                        ])
                    @endforeach
                @else
                    <li class="text-info list-group-item">
                        <p class="text-center text-light"><em>Sem tarefas novas.</em></p>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col col-6">
            <ul class="list-group">
                <li class="text-white list-group-item text-center">
                    <div class="d-flex justify-content-evenly">
                        <b class="text-center mx-auto">Lista de tarefas</b>
                        <a class="link-underline link-underline-opacity-0 link-opacity-50-hover"
                            href="{{ route('tasklist.show') }}"><em>Acessar</em></a>
                    </div>
                </li>
                @if (sizeof($lists) > 0)
                    @foreach ($lists as $list)
                        <li class="text-info list-group-item list-group-item-action" data-bs-toggle="modal"
                            data-bs-target="#list-resume-{{ $list->id }}">
                            <div class="d-flex justify-content-between">
                                <div class="text-info text-start text-truncate col-6">{{ $list->name }}</div>
                                @if (isset($list->description))
                                    <div class="text-white text-truncate col-4 text-end">{{ $list->description }}
                                    </div>
                                @else
                                    <div class="text-light text-end"><em>Sem descrição.</em></div>
                                @endif
                            </div>
                        </li>
                        @include('partials.tasklist.modal_list_resume', [
                            'modal_id' => 'list-resume-' . $list->id,
                            'form_title' => 'Resumo da lista de tarefas',
                            'list' => $list,
                        ])
                    @endforeach
                @else
                    <li class="text-info list-group-item">
                        <p class="text-center text-light"><em>Sem listas de tarefas novas.</em></p>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    @include('partials.main.footer')

@endsection
