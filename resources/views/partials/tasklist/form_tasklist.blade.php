{{-- modal edit --}}
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="modalTask-{{ $modal_id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="taskEditTitle">{{ $form_title }}</h1>
            </div>
            <div class="p-3 modal-body">
                <form action="{{ route($route) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $list_id }}">
                    {{-- task name --}}
                    <div class="mb-3 form-floating">
                        <input type="text" name="name" id="name" class="mb-2 form-control"
                            placeholder="Nome da lista" required value="{{ old('name', $list_name) }}">
                        <label for="name" class="form-label">Nome da
                            Lista</label>
                        @error('name')
                            <div class="text-warning">{{ $errors->get('name')[0] }}</div>
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
                        <label for="description" class="form-label">Descrição da Lista</label>
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

                    {{-- cancel or submit --}}
                    <div class="text-center row">
                        <button type="button" class="px-2 m-3 shadow shadow-md col btn btn-secondary"
                            data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="px-2 m-3 shadow shadow-md col btn btn-success">
                            <i class="bi bi-floppy me-2"></i>
                            Guardar
                        </button>
                    </div>
                </form>

                @if (session()->has('task_error'))
                    <div class="p-1 text-center alert alert-danger"> {{ session()->get('task_error') }} </div>
                @endif

            </div>
        </div>
    </div>
</div>
