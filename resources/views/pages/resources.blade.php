    @extends('templates.login_layout') @section('content')

    @section('content')

        @include('partials.visitant.nav')

        <div class="container-resources py-5">
            <h3 class="display-4 mb-5 resource-title">Um pouco do que temos... Por enquanto...</h3>
            <ul class="resource-list">
                <li>
                    <strong>Gamificação:</strong> Ganhe experiência ao concluir tarefas e avance de
                    nível
                    progressivamente.
                </li>
                <li>
                    <strong>Login via Google:</strong> Loge em segundos com poucos cliques usando sua conta de e-mail
                    Google, é seguro e rápido!.
                </li>
                <li>
                    <strong>Criação de Tarefas:</strong> Crie uma tarefa e de um nome e ou descrição para organizar suas
                    tarefas, trabalho e o que precisar.
                </li>
                <li>
                    <strong>Desvincular ou vincular uma terefa a uma lista:</strong> Envia suas tarefas para fora de listas
                    ou para outras listas como desejar.
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
                <li>
                    <strong>Filtro por Situação:</strong> Escolha se quer visualizar suas tarefas concluídas, em progresso
                    ou outro status que preferir.
                </li>
            </ul>
        </div>

    @endsection
