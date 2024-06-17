<div class="bg-dark text-white mb-3 shadow container-fluid ">
    {{-- <div class="container w-100"> --}}
    <div class="navbar navbar-expand-lg navbar-dark row align-items-center pt-2 pb-0">
        <div class="col">
            <a href="{{ route('task.userhome') }}" class="btn btn-dark"><i class="bi bi-person fs-5 me-1"></i>
                {{ $user_name }}</a>
        </div>

        <div class="col-auto">
            <span class=" shadow shadow-md btn-xs" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavMain"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
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
        <div class="col d-flex justify-content-center">
            <span class="text-success text-center">Nível {{ $user_level }} - {{ $user_experience }}%</span>
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
