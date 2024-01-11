<div class="bg-black text-white mb-5">
    <div class="contaner-fluid">
        <div class="row align-items-center mx-4">
            <div class="col p-3">
                <h3 class="text-primary">Gestor de Tarefas</h3>
            </div>
            <div class="col p-3 text-end">

                <span><i class="bi bi-person me-2"></i>{{ session()->get('username') }}</span>
                <span class="mx-3 opacity-50"><i class="bi bi-three-dots-vertical"></i></span>
                <a href="{{ route('main.logout') }} " class="btn btn-outline-danger"><i
                        class="bi bi-box-arrow-right me-2"></i>Sair</a>

            </div>
        </div>
    </div>
</div>
