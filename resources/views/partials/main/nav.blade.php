<div class="bg-black text-white mb-5 shadow">
    <div class="contaner-fluid">
        <div class="row align-items-center mx-4">
            <div class="col p-3">
                <a href="/" class="btn btn-dark">Minhas Tarefas</a>
            </div>
            <div class="col p-3 text-end">

                <span><i class="bi bi-person me-2"></i>{{ session()->get('username') }}</span>
                <span class="mx-3 opacity-50"><i class="bi bi-three-dots-vertical"></i></span>
                <a href="{{ route('logout.submit') }} " class="btn btn-outline-danger"><i
                        class="bi bi-box-arrow-right me-2"></i>Sair</a>

            </div>
        </div>
    </div>
</div>
