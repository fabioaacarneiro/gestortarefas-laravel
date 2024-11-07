<div class="bg-dark text-white mb-3 shadow container-fluid ">
    {{-- <div class="container w-100"> --}}
    <div class="navbar navbar-expand-lg navbar-dark row align-items-center pt-2 pb-0">
        <div class="col">
            <a href="{{ route('task.userhome') }}" class="btn btn-dark"><i class="bi bi-person fs-5 me-1"></i>{{ $user_name }}</a>
        </div>
        
        <div class="col">
            <span class="d-lg-none m-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavMain"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 me-3"></i>
            </span>
        </div>
    
        <div class="col-auto d-none d-sm-none d-md-none d-lg-block">
            <span><a href="{{ url()->previous() }}"
                class="btn btn-dark link-underline link-underline-opacity-0 link-opacity-50-hover">Voltar</a></span>
            <span><a href="{{ route('task.show') }}"
                class="btn btn-dark link-underline link-underline-opacity-0 link-opacity-50-hover">Tarefas</a></span>
            <span><a href="{{ route('tasklist.show') }}"
                class="btn btn-dark link-underline link-underline-opacity-0 link-opacity-50-hover">Listas</a></span>
        </div>
                
        <div class="col-auto">
            <form class="py-0" action="{{ route('logout.submit') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right">Sair</i></button>
            </form>
        </div> 
    </div>

    <div class="row mb-2">
        <div class="col-auto d-flex justify-content-start" id="actual_task_running_container">
            <div class="d-flex align-items-center justify-content-center rounded shadow" role="alert" id="actual_task_running_message">
                @if ($taskNameGlobal)
                    <span class="bg-success py-1 pe-2 rounded" id="btnMessageRunningTask"><i class="bi bi-stopwatch ms-2 me-1"></i><em><strong>{{ $taskNameGlobal }}</strong> da lista <strong>{{ $listNameGlobal }}</strong></em></span>
                @endif
            </div>
        </div>
    
        <div class="col d-flex justify-content-end">
            <span class="text-success text-center py-1">Nível {{ $user_level }} - {{ $user_experience }}%</span>
        </div>
    </div>

    <div class="d-lg-none row mb-2 fs-5">
        <div class="col-sm-12">
            <div class="collapse navbar-collapse" id="navbarNavMain">
                <hr class="align-itens-center w-75 mx-auto">
                <div class="d-flex justify-content-evenly">
                    <span><a href="{{ url()->previous() }}"
                            class="btn btn-dark link-underline link-underline-opacity-0 link-opacity-50-hover">Voltar</a></span>
                    <span><a href="{{ route('task.show') }}"
                            class="btn btn-dark link-underline link-underline-opacity-0 link-opacity-50-hover">Tarefas</a></span>
                    <span><a href="{{ route('tasklist.show') }}"
                            class="btn btn-dark link-underline link-underline-opacity-0 link-opacity-50-hover">Listas</a></span>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
</div>