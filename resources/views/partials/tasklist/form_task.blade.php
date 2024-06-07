{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5 text-info" id="taskEditTitle">{{ $form_title }}</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route($route, $list_id) }}" method="POST" id="form-new-edit-post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $task_id }}">
                    {{-- task name --}}
                    <div class="mb-3 form-floating">
                        <input type="text" name="name" id="name" class="mb-2 form-control"
                            placeholder="Nome da tarefa" value="{{ old('name', $name) }}">
                        <label for="name" class="form-label">Nome da Tarefa</label>
                        @error('name')
                            <div class="text-warning">
                                {{ $errors->get('name')[0] }}
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", (event) => {
                                    const myModal = new bootstrap.Modal({{ $modal_id }}, {
                                        keyboard: true,
                                        dispose: true
                                    })
                                    myModal.show({{ $modal_id }})
                                })
                            </script>
                        @enderror
                    </div>

                    {{-- task description --}}
                    <div class="mb-3 form-floating">
                        <textarea name="description" id="description" style="height: 250px" class="pt-4 form-control"
                            placeholder="Conteúdo da tarefa">{{ old('description', $description) }}</textarea>
                        <label for="description" class="form-label">Descrição da Tarefa</label>
                        @error('description')
                            <div class="text-warning">{{ $errors->get('description')[0] }}</div>
                            <script>
                                document.addEventListener("DOMContentLoaded", (event) => {
                                    const myModal = new bootstrap.Modal({{ $modal_id }}, {
                                        keyboard: true,
                                        dispose: true
                                    })
                                    myModal.show({{ $modal_id }})
                                })
                            </script>
                        @enderror
                    </div>

                    {{-- alimentando a lista de tarefas --}}
                    <div hx-get="{{ route('tasklist.get', $task_id) }}" hx-trigger="load"
                        hx-target="#get-lists-response-{{ $task_id }}">
                        <label for="get-lists-response-{{ $task_id }}">Escolha uma lista:</label>
                        @if ($status === 'new')
                            <select class="form-select" name="list" disabled>
                                <option value="{{ $list_id }}" selected>
                                    {{ $name }}
                                </option>
                            </select>
                        @else
                            <select class="form-select" id="get-lists-response-{{ $task_id }}" name="list">
                                {{-- será populado aqui --}}
                            </select>
                        @endif
                        </select>
                    </div>

                    {{-- task status --}}
                    <label class="mt-3" for="get-lists-response-{{ $task_id }}">Escolha um status:</label>
                    @if ($type == 'edit')
                        <div>
                            <select name="status" id="status" class="form-select">
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
                            @enderror
                        </div>
                    @else
                        <div>
                            <select name="status" id="status" class="form-select" disabled>
                                <option value="new" selected>
                                    Nova
                                </option>
                            </select>
                        </div>
                    @endif
                    <hr class="my-3">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="mx-2 shadow shadow-md btn btn-secondary" data-bs-dismiss="modal"
                            title="Cancele as mudanças">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="shadow shadow-md btn btn-success" title="Guarde as mudanças">
                            <i class="bi bi-floppy me-2"></i>Guardar
                        </button>
                    </div>

                </form>


                @if (session()->has('task_error'))
                    <div class="p-1 text-center alert alert-danger"> {{ session()->get('task_error') }} </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", (event) => {
                            const myModal = new bootstrap.Modal({{ $modal_id }}, {
                                keyboard: true,
                                dispose: true
                            })
                            myModal.show({{ $modal_id }})
                        })
                    </script>
                @endif

            </div>
        </div>
    </div>
</div>
