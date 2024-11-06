@extends('templates.project_report_layout')

@section('content')
<div class="report-container">
    <!-- Título do Relatório -->
    <h1 class="report-title">Relatório de Atividades</h1>
    
    <!-- Informações do Cliente e Projeto -->
    <div class="client-info">
        <h2>Cliente: <span>{{ $client_name }}</span></h2>
        <h3>Responsável: <span>{{ $username }} {{ $lastName }}</span></h3>
        @if ($project_description)
        <p><strong>Descrição do Projeto:</strong></em></p>
        <p>{{ $project_description }}</p>
        @else
        <p><strong>Descrição do Projeto:</strong> <em>Sem descrição</em></p>
        @endif
    </div>

    <!-- Tabela de Tarefas -->
    <table class="task-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Status</th>
                <th>Tempo</th>
                <th>Descrição</th>
                <th>Comentários</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->elapsed_time }}</td>
                <td>
                    @if ($task->description)
                        <p>{{ $task->description }}</p>
                    @else
                        <p><em>Sem descrição</em></p>
                    @endif
                </td>
                <td>
                    @if ($task->commentary)
                        <p>{{ $task->commentary }}</p>
                    @else
                        <p><em>Sem comentário</em></p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tempo Total -->
    <p class="total-time"><strong>Tempo total: {{ $total_time_worked }}</strong></p>

</div>

<!-- Estilos Customizados -->
<style>
    /* Layout e Estilos Gerais */
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }

    .report-container {
        height: 100vh;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
    }

    /* Título do Relatório */
    .report-title {
        text-align: center;
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    /* Informações do Cliente e Projeto */
    .client-info {
        margin-bottom: 20px;
    }

    .client-info h2, .client-info h3 {
        font-size: 20px;
        color: #333;
    }

    .client-info span {
        color: #007bff;
    }

    .client-info p {
        font-size: 16px;
        color: #555;
    }

    /* Tabela de Tarefas */
    .task-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .task-table th, .task-table td {
        padding: 12px;
        font-size: 16px;
        text-align: left;
        color: #333;
    }

    .task-table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .task-table td {
        background-color: #f9f9f9;
        border-bottom: 1px solid #e0e0e0;
    }

    .task-table td p {
        margin: 0;
    }

    .task-table td em {
        color: #888;
    }

    /* Tempo Total */
    .total-time {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        text-align: right;
    }

</style>
@endsection
