<?php


function translateStatus($status)
{
    $status_collection = [
        'all' => 'Minhas Tarefas',
        'new' => 'Nova',
        'in_progress' => 'Em progresso',
        'cancelled' => 'Cancelada',
        'completed' => 'Concluída',
    ];

    if (key_exists($status, $status_collection)) {
        echo $status_collection[$status];
    } else {
        echo 'Desconhecido';
    }
}

function itemListStatusBackgroundColor($status)
{
    $status_collection = [
        'new' => 'list-group-item-success',
        'in_progress' => 'list-group-item-info',
        'cancelled' => 'list-group-item-danger',
        'completed' => 'list-group-item-secondary',
    ];

    if (key_exists($status, $status_collection)) {
        echo $status_collection[$status];
    } else {
        echo '';
    }
}
