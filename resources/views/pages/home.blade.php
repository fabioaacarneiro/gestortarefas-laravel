@extends('templates.main_layout') @section('content')
@section('content')

    @include('partials.visitant.nav')

    <header class="text-center py-5">
        <div class="container">
            <div class="display-4">
                <img src="{{ asset('assets/img/small/full-logo-dark-theme.png') }}" alt="Full loco Ramtask">
            </div>
            <p class="lead">Seu Assistente Digital para Gerenciamento de Tarefas</p>
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4">Experimente Agora</a>
        </div>
    </header>

    <section class="pb-5">
        <div class="container img-examples">
            <div class="row px-2">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <h2>Organize suas Tarefas</h2>
                    <p>Gerencie suas tarefas acadêmicas, profissionais e pessoais de forma centralizada.</p>
                    <div class="container-img">
                        <img src="{{ asset('assets/img/examples/img-1.png') }}" alt="imagem de exemplo tarefas faculdade"
                            class="img-example">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <h2>Detalhe suas Tarefas</h2>
                    <p>Adicione descrições detalhadas e anotações importantes a cada tarefa para melhor organização.</p>
                    <div class="container-img">
                        <img src="{{ asset('assets/img/examples/img-2.png') }}" alt="imagem de exemplo detalhar as tarefas"
                            class="img-example">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <h2>Planeje suas Viagens</h2>
                    <p>Crie listas de itens para viagem para garantir que você esteja sempre preparado.</p>
                    <div class="container-img">
                        <img src="{{ asset('assets/img/examples/img-3.png') }}" alt="imagem de exemplo tarefas da viagem"
                            class="img-example">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center bg-dark">
        <div class="container pt-3 pb-2">
            <p>&copy; <?php echo date('Y'); ?> RamTask. Todos os direitos reservados.</p>
        </div>
    </footer>

@endsection
