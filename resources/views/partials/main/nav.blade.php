<div class="bg-dark text-white mb-3 shadow">
    <div class="contaner-fluid">
        <div class="row align-items-center mx-4">
            <div class="col-auto col-md p-1">
                <a href="/" class="btn btn-dark">Início</a>
            </div>
            <div class="col col-sm p-3 text-end">
                <span><i class="bi bi-person"></i>{{ $name }}</span>
            </div>
            <div class="col col-auto">
                <span class="opacity-50"><i class="bi bi-three-dots-vertical"></i></span>
            </div>
            <div class="col col-auto">
                <form action="{{ route('logout.submit') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger my-3"><i
                            class="bi bi-box-arrow-right">Sair</i></button>
                </form>
            </div>
        </div>
    </div>
</div>
