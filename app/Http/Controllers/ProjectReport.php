<?php

namespace App\Http\Controllers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProjectReport extends Controller
{
    private function formatTaskTime(int $seconds)
    {
        $hours = floor($seconds / 3600);
        $secondsLeft = $seconds % 3600;

        $minutes = floor($secondsLeft / 60);

        $seconds = $secondsLeft % 60;

        $minutes = $minutes < 10 ? "0$minutes" : $minutes;
        $hours = $hours < 10 ? "0$hours" : $hours;
        $seconds = $seconds < 10 ? "0$seconds" : $seconds;

        return "$hours:$seconds:$seconds";
    }

    public function downloadPDF(Request $request)
    {
        $request->validate([
            "client_name" => "required|min:5",
            "list_id" => "required|int|min:1",
        ]);

        $taskList = TasklistModel::where('id', $request->input('list_id'))->first();

        $tasks = TaskModel::where(
            'tasklist_id',
            $taskList->id
        )->get();

        $user = UserModel::where('id', $taskList->user_id)->first();
        
        $totalTimeWorked = 0;
        foreach ($tasks as $task) {
            $totalTimeWorked += $task->elapsed_time;
        }
        $totalTimeWorked = $this->formatTaskTime($totalTimeWorked);
        
        foreach ($tasks as $task) {
            $task->elapsed_time = $this->formatTaskTime($task->elapsed_time);
        }


        $data = [
            'title' => 'Resumo do relatório',
            'client_name' => $request->input('client_name'),
            'list_id' => $request->input('list_id'),
            'project_description' => $request->input('project_description'),
            'tasks' => $tasks ?? [],
            'total_time_worked' => $totalTimeWorked,
            'username' => $user->name,
            'lastName' => $user->lastName,
        ];

        // Gera o PDF a partir da view e passa os dados
        $pdf = Pdf::loadView('pages.project_report_resume', $data);

        // Retorna o PDF para download
        return $pdf->download('relatorio_' . $request->input('client_name') . '.pdf');
    }
}
