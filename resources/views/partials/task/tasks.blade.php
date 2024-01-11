{{-- @dd($tasks) --}}
<div class="container mb-3">
    <div class="row">
        <div class="col">

            <div class="row align-items-center mb-3">
                <div class="col">
                    <h4>Tarefas</h4>
                </div>

                <div class="col-8 text-center">
                    <form action="{{ route('task.search_submit') }}" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="text_search" id="text_search" class="form-control"
                                placeholder="Pesquisar">
                            <button class="btn btn-outline-primary ms-3"><i class="bi bi-search"></i></button>
                            <span class="mx-3"></span>
                            <label class="me-2 align-self-center">Estado:</label>
                            <select name="filter" id="filter" class="form-select">
                                <option value="{{ Crypt::encrypt('all') }}"
                                    @php echo (!empty($filter) && $filter == 'all') ? 'selected' : '' @endphp>Todos
                                </option>
                                <option value="{{ Crypt::encrypt('new') }}"
                                    @php echo (!empty($filter) && $filter == 'new') ? 'selected' : '' @endphp>Novas
                                </option>
                                <option value="{{ Crypt::encrypt('in_progress') }}"
                                    @php echo (!empty($filter) && $filter == 'in_progress') ? 'selected' : '' @endphp>Em
                                    progresso</option>
                                <option value="{{ Crypt::encrypt('cancelled') }}"
                                    @php echo (!empty($filter) && $filter == 'cancelled') ? 'selected' : '' @endphp>
                                    Canceladas</option>
                                <option value="{{ Crypt::encrypt('completed') }}"
                                    @php echo (!empty($filter) && $filter == 'completed') ? 'selected' : '' @endphp>
                                    Concluídas</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="col text-end">
                    <a href="{{ route('task.new_task') }}" class="btn btn-primary"><i
                            class="bi bi-plus-square me-2"></i>Nova
                        tarefa</a>
                </div>
            </div>

            @if (count($tasks) != 0)
                <table class="table table-dark table-striped table-bordered w-100" id="table_tasks">
                    <thead class="table-primary">
                        <tr>
                            <th class="w-75">Tarefas</th>
                            <th class="w-20 text-center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-light">
                        {{-- @foreach ($tasks as $task)
                            <tr>
                                <td><span>{{ $task['task_name'] }}</span></td>
                                <td>{{ $task['task_status'] }}</td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            @else
                <p class="text-center opacity-50 my-5">Não existem tarefas registradas</p>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table_tasks').DataTable({
            data: @json($tasks),
            columns: [{
                    data: 'task_name'
                },
                {
                    data: 'task_status',
                    className: 'text-center align-middle'
                },
                {
                    data: 'task_actions',
                    className: 'text-center align-middle'
                },
            ]
        })
    })

    let filter = document.querySelector('#filter')
    filter.addEventListener('change', () => {
        let value = filter.value
        window.location.href = `{{ url('/filter') }}/${value}`
        console.log(`{{ url('/filter') }}/${value}`)
    })
</script>