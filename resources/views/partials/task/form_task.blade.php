{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1"
    aria-labelledby="modalTask-{{ $modal_id }} aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="taskEditTitle">{{ $form_title }}</h1>
            </div>
            <div class="modal-body">
                <div class="col">
                    <form action="{{ route($route) }}" method="post">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ Crypt::encrypt($task_id) }}">
                        {{-- task name --}}
                        <div class="mb3">
                            <label for="text_task_name" class="form-label">Nome da
                                Tarefa</label>
                            <input type="text" name="text_task_name" id="text_task_name" class="form-control"
                                placeholder="Nome da tarefa" required value="{{ old('text_task_name', $task_name) }}">
                            @error('text_task_name')
                                <div class="text-warning">
                                    {{ $errors->get('text_task_name')[0] }}
                                </div>
                            @enderror
                        </div>

                        {{-- task description --}}
                        <div class="mb3">
                            <label for="text_task_description" class="form-label mt-2">Descrição da Tarefa</label>
                            <textarea name="text_task_description" id="text_task_description" rows="10" class="form-control mb-4" required>{{ old('text_task_description', $task_description) }}</textarea>
                            @error('text_task_description')
                                <div class="text-warning">
                                    {{ $errors->get('text_task_description')[0] }}</div>
                            @enderror
                        </div>

                        {{-- task status --}}
                        <div class="mb-3 d-flex flex-column">
                            <label for="text_task_status" class="form-label">Status
                                da tarefa</label>
                            <select name="text_task_status" id="text_task_status" class="form-select flex-fill"
                                required>
                                <option value="new"
                                    {{ old('text_task_status', $task_status) == 'Nova' ? 'selected' : '' }}>
                                    Nova</option>
                                <option value="in_progress"
                                    {{ old('text_task_status', $task_status) == 'Em progresso' ? 'selected' : '' }}>
                                    Em
                                    progresso</option>
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
                                <div class="text-warning">
                                    {{ $errors->get('text_task_status')[0] }}</div>
                            @enderror
                        </div>

                        {{-- cancel or submit --}}
                        <div class="mb-3 text-center">
                            <hr>
                            {{-- <a href="{{ route('task.index') }} " class="btn btn-secondary px-5 m-1"><i
                                class="bi bi-x-circle me-2"></i>Cancelar</a> --}}
                            <button type="button" class="btn btn-secondary px-5 m-1"><i class="bi bi-floppy me-2"
                                    data-bs-toggle></i>Cancelar</button>
                            <button type="submit" class="btn btn-success px-5 m-1"><i
                                    class="bi bi-floppy me-2"></i>Guardar</button>
                        </div>
                    </form>

                    @if (session()->has('task_error'))
                        <div class="alert alert-danger text-center p-1">
                            {{ session()->get('task_error') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
