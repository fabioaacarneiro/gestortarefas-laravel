<div class="container">
    <div class="row mt-5">
        <div class="col">
            <h4>Ecluir Tarefa</h4>
            <hr>
            <h4 class="text-info">{{ $task->task_name }}</h4>
            <p class="opacity-50">{{ $task->task_description }}</p>
            <p class="my-5 text-center">Deseja excluir esta tarefa?</p>
            <div class="my-4 text-center">
                <a href="{{ route('main.index') }}" class="btn btn-dark px-5 m-1"><i
                        class="bi bi-x-circle me-2"></i>Cancelar</a>
                <a href="{{ route('task.delete_task_confirm', ['id' => Crypt::encrypt($task->id)]) }}"
                    class="btn btn-danger px-5 m-1"><i class="bi bi-thrash me-2"></i>Confirmar</a>
            </div>
        </div>
    </div>
</div>
