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
                    <input type="hidden" name="id" value="{{ $id }}">
                    {{-- task name --}}
                    <div class="mb-3 form-floating">
                        <input type="text" name="name" id="name" class="form-control mb-2"
                            placeholder="Nome da lista" required value="{{ old('name', $name) }}">
                        <label for="name" class="form-label">Nome da
                            Lista</label>
                        @error('name')
                            <div class="text-warning">
                                {{ $errors->get('name')[0] }}
                            </div>
                        @enderror
                    </div>

                    {{-- task description --}}
                    <div class="mb-3 form-floating">
                        <textarea name="description" id="description" style="height: 250px" class="form-control pt-4"
                            placeholder="Conteúdo da tarefa" required>{{ old('description', $description) }}</textarea>
                        <label for="description" class="form-label">Descrição da Lista</label>
                        @error('description')
                            <div class="text-warning">{{ $errors->get('description')[0] }}</div>
                        @enderror
                    </div>

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
                @endif

            </div>
        </div>
    </div>
</div>
