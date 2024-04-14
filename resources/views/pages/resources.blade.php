    @extends('templates.login_layout') @section('content')

    @section('content')

        @include('partials.visitant.nav')

        <div class="container-resources py-5">
            <h3 class="display-4 mb-5 resource-title">Recursos do Projeto</h3>
            <ul class="resource-list">
                <li>
                    <strong>Gamificação:</strong> Ganhe experiência ao concluir tarefas e avance de
                    nível
                    progressivamente.
                </li>
                <li>
                    <strong>Criação de Listas de Tarefas:</strong> Crie listas com nome e descrição para organizar suas
                    tarefas.
                </li>
                <li>
                    <strong>Criação de Tarefas:</strong> Adicione tarefas com título, descrição e comentários para lembretes
                    e observações importantes.
                </li>
                <li>
                    <strong>Edição da Situação da Tarefa:</strong> Altere o status da tarefa entre concluída, cancelada e em
                    progresso.
                </li>
                <li>
                    <strong>Exclusão de Tarefas:</strong> Remova tarefas conforme necessário.
                </li>
                <li>
                    <strong>Pesquisa por Texto:</strong> Use o buscador para encontrar tarefas por título, descrição ou
                    situação.
                </li>
            </ul>
        </div>

    @endsection
