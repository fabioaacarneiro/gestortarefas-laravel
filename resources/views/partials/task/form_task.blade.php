{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="modalTask-{{ $modal_id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="taskEditTitle">{{ $form_title }}</h1>
            </div>
            <div class="modal-body p-3">
                <form action="{{ route($route) }}" method="POST">
                    @csrf
                    <input type="hidden" name="task_id" value="{{ $task_id }}">
                    {{-- task name --}}
                    <div class="mb-3 form-floating">
                        <input type="text" name="text_task_name" id="text_task_name" class="form-control mb-2"
                            placeholder="Nome da tarefa" required value="{{ old('text_task_name', $task_name) }}">
                        <label for="text_task_name" class="form-label">Nome da
                            Tarefa</label>
                        @error('text_task_name')
                            <div class="text-warning">
                                {{ $errors->get('text_task_name')[0] }}
                            </div>
                        @enderror
                    </div>

                    {{-- task description --}}
                    <div class="mb-3 form-floating">
                        <textarea name="text_task_description" id="text_task_description" style="height: 250px" class="form-control pt-4"
                            placeholder="Conteúdo da tarefa" required>{{ old('text_task_description', $task_description) }}</textarea>
                        <label for="text_task_description" class="form-label">Descrição da Tarefa</label>
                        @error('text_task_description')
                            <div class="text-warning">{{ $errors->get('text_task_description')[0] }}</div>
                        @enderror
                    </div>

                    {{-- task status --}}
                    <div>
                        <select name="text_task_status" id="text_task_status" class="form-select" required>
                            <option value="new"
                                {{ old('text_task_status', $task_status) == 'Nova' ? 'selected' : '' }}>
                                Nova
                            </option>
                            <option value="in_progress"
                                {{ old('text_task_status', $task_status) == 'Em progresso' ? 'selected' : '' }}>
                                Em progresso
                            </option>
                            <option value="cancelled"
                                {{ old('text_task_status', $task_status) == 'Cancelada' ? 'selected' : '' }}>
                                Cancelada
                            </option>
                            <option value="completed"
                                {{ old('text_task_status', $task_status) == 'Concluída' ? 'selected' : '' }}>
                                Concluída
                            </option>
                        </select>
                        @error('text_task_status')
                            <div class="text-warning">{{ $errors->get('text_task_status')[0] }}</div>
                        @enderror
                    </div>

                    {{-- cancel or submit --}}
                    <div class="row text-center">
                        <hr class="mt-5">
                        {{-- <a href="{{ route('task.index') }} " class="btn btn-secondary px-5 m-1"><i
                                class="bi bi-x-circle me-2"></i>Cancelar</a> --}}
                        <button type="button" class="col btn btn-secondary px-2 m-3" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="col btn btn-success px-2 m-3">
                            <i class="bi bi-floppy me-2"></i>
                            Guardar
                        </button>
                    </div>
                </form>

                @if (session()->has('task_error'))
                    <div class="alert alert-danger text-center p-1"> {{ session()->get('task_error') }} </div>
                @endif

            </div>
        </div>
    </div>
</div>
