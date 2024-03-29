<div class="bg-dark text-white mb-3 shadow">
    <div class="contaner-fluid">
        <div class="row align-items-center mx-4">
            <div class="col col-md p-1">
                <span><a href="/" class="btn btn-dark"><i class="bi bi-person"></i>{{ $user_name }}</a></span>
            </div>
            <div class="col col-md p-1">
                <span class="text-success">Nível {{ $user_level }} - {{ $user_experience }}%</span>
            </div>
            {{-- <div class="col col-sm p-3 text-end">
                <span><i class="bi bi-person"></i>{{ $user_name }}</span>
            </div>
            <div class="col col-auto">
                <span class="opacity-50"><i class="bi bi-three-dots-vertical"></i></span>
            </div> --}}
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
