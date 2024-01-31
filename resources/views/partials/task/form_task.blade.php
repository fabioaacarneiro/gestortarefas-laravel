{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="taskEditTitle">{{ $form_title }}</h1>
            </div>
            <div class="modal-body p-3">
                <form action="{{ route($route, $tasklist_id) }}" method="POST" id="form-new-edit-post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    {{-- task name --}}
                    <div class="mb-3 form-floating">
                        <input type="text" name="name" id="name" class="form-control mb-2"
                            placeholder="Nome da tarefa" required value="{{ old('name', $name) }}">
                        <label for="name" class="form-label">Nome da
                            Tarefa</label>
                        @error('name')
                            <div class="text-warning">
                                {{ $errors->get('name')[0] }}
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", (event) => {
                                    const myModal = new bootstrap.Modal('#new_task', {
                                        keyboard: true,
                                        dispose: true
                                    })
                                    myModal.show('#new_task')
                                })
                            </script>
                        @enderror
                    </div>

                    {{-- task description --}}
                    <div class="mb-3 form-floating">
                        <textarea name="description" id="description" style="height: 250px" class="form-control pt-4"
                            placeholder="Conteúdo da tarefa" required>{{ old('description', $description) }}</textarea>
                        <label for="description" class="form-label">Descrição da Tarefa</label>
                        @error('description')
                            <div class="text-warning">{{ $errors->get('description')[0] }}</div>
                            <script>
                                document.addEventListener("DOMContentLoaded", (event) => {
                                    const myModal = new bootstrap.Modal('#new_task', {
                                        keyboard: true,
                                        dispose: true
                                    })
                                    myModal.show('#new_task')
                                })
                            </script>
                        @enderror
                    </div>

                    {{-- task status --}}
                    @if ($type == 'edit')
                        <div>
                            <select name="status" id="status" class="form-select" required>
                                <option value="new" {{ old('status', $status) == 'Nova' ? 'selected' : '' }}>
                                    Nova
                                </option>
                                <option value="in_progress"
                                    {{ old('status', $status) == 'Em progresso' ? 'selected' : '' }}>
                                    Em progresso
                                </option>
                                <option value="cancelled"
                                    {{ old('status', $status) == 'Cancelada' ? 'selected' : '' }}>
                                    Cancelada
                                </option>
                                <option value="completed"
                                    {{ old('status', $status) == 'Concluída' ? 'selected' : '' }}>
                                    Concluída
                                </option>
                            </select>
                            @error('status')
                                <div class="text-warning">{{ $errors->get('status')[0] }}</div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", (event) => {
                                        const myModal = new bootstrap.Modal('#new_task', {
                                            keyboard: true,
                                            dispose: true
                                        })
                                        myModal.show('#new_task')
                                    })
                                </script>
                            @enderror
                        </div>
                    @else
                        <div>
                            <select name="status" id="status" class="form-select" disabled required>
                                <option value="new" selected>
                                    Nova
                                </option>
                            </select>
                        </div>
                    @endif
                    {{-- cancel or submit --}}
                    <div class="row text-center">
                        <hr class="mt-5">
                        {{-- <a href="{{ route('task.index') }} " class="btn btn-secondary px-5 m-1"><i
                                class="bi bi-x-circle me-2"></i>Cancelar</a> --}}
                        <button type="button" class="col btn btn-secondary px-2 m-3 shadow shadow-md"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="col btn btn-success px-2 m-3 shadow shadow-md">
                            <i class="bi bi-floppy me-2"></i>
                            Guardar
                        </button>
                    </div>
                </form>

                @if (session()->has('task_error'))
                    <div class="alert alert-danger text-center p-1"> {{ session()->get('task_error') }} </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", (event) => {
                            const myModal = new bootstrap.Modal('#new_task', {
                                keyboard: true,
                                dispose: true
                            })
                            myModal.show('#new_task')
                        })
                    </script>
                @endif

            </div>
        </div>
    </div>
</div>
