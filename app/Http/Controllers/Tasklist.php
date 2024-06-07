<?php

namespace App\Http\Controllers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class Tasklist extends Controller
{
    public function index()
    {
        static::checkAuthAndRedirect();
        return redirect()->route('tasklist.show');
    }

    public function getTasklists($task_id = null)
    {

        $task = TaskModel::find($task_id);
        $allTasklists = TasklistModel::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        $noListOption = '<option value="null" selected >Sem lista.</option>';
        $options = '';

        foreach ($allTasklists as $list) {
            if ($task->tasklist_id === $list->id) {
                $options .= '<option value="' . $list->id . '" selected >' .  $list->name . '</option>';
            } else {
                $options .= '<option value="' . $list->id . '">' .  $list->name . '</option>';
            }
        }

        if (isNull($task)) {
            $options = $noListOption . $options;
        }

        return $options;
    }

    public function showTasklist()
    {

        static::checkAuthAndRedirect();

        $tasklist = TasklistModel::where('user_id', Auth::user()->id)->first();

        $amountOfCompletedTasks = 0;

        try {
            $amountOfCompletedTasks = TaskModel::where('tasklist_id', $tasklist->id)
                ->where('status', 'completed')
                ->count();
        } catch (Exception $exception) {
            $amountOfCompletedTasks = 0;
        }

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp($amountOfCompletedTasks);

        $data = [
            'title' => 'Lista de tarefas',
            'user_name' => Auth::user()->name,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'lists' => Tasklist::getLists(),
        ];

        return view('pages.tasklist', $data);
    }

    public function storeTasklistGet()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            return back();
        }
    }

    public function storeTasklist(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tasklists|min:3|max:200',
            'description' => 'nullable|max:1000',
        ], [
            'name.required' => 'O campo é obrigatório.',
            'name.unique' => 'A lista de tarefas já existe, use outro nome.',
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo deve ter no máximo :max caracteres.',
            'description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        // get form data
        $name = $request->input('name');
        $description = $request->input('description');

        TasklistModel::create([
            'user_id' => Auth::user()->id,
            'name' => $name,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('tasklist.index');
    }

    public function editTasklist(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:200',
            'description' => 'max:255|nullable',
        ], [
            'name.min' => 'O campo deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo deve ter no máximo :max caracteres.',
            'description.max' => 'O campo deve ter no máximo :max caracteres.',
        ]);

        // get form data
        $id = $request->get('id');
        $name = $request->get('name');
        $description = $request->get('description');

        $tasklist = TasklistModel::find($id);
        $tasklist->name = $name;
        $tasklist->description = $description;
        $tasklist->updated_at = date('Y-m-d H:i:s');
        $tasklist->save();

        // $tasklists = Tasklist::getLists();

        return redirect()->route('tasklist.show');
    }

    public function deleteTasklist($id)
    {
        try {
            TaskModel::where('tasklist_id', $id)
                ->delete();

            TasklistModel::where('id', $id)
                ->delete();
        } catch (\Throwable $th) {
            throw $th;
        }

        return back();
    }

    public function searchTasklist($search = null)
    {
        $tasklist = TasklistModel::where('user_id', Auth::user()->id)->first();

        $amountOfCompletedTasks = 0;

        try {
            $amountOfCompletedTasks = TaskModel::where('tasklist_id', $tasklist->id)
                ->where('status', 'completed')
                ->count();
        } catch (Exception $exception) {
            $amountOfCompletedTasks = 0;
        }

        ['lvl' => $lvl, 'exp' => $exp] = Task::getLevelAndExp($amountOfCompletedTasks);

        $tasklists = [];

        // get tasks
        if ($search) {
            $allTasklists = TasklistModel::where('user_id', Auth::user()->id)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere(DB::raw('lower(description)'), 'like', '%' . strtolower($search) . '%')
                        ->orderBy('created_at', 'DESC');
                })->whereNull('deleted_at')
                ->get();

            foreach ($allTasklists as $list) {

                $tasklists[] = [
                    'id' => $list['id'],
                    'name' => $list['name'],
                    'description' => $list['description'],
                ];
            }
        } else {
            $tasklists = Tasklist::getLists();
        }

        $data = [
            'title' => 'Listas de Tarefas',
            'user_name' => Auth::user()->name,
            'lists' => $tasklists,
            'user_level' => $lvl,
            'user_experience' => $exp,
        ];

        return view('pages.tasklist', $data);
    }

    private static function getLists()
    {
        // return UserModel::find(Auth::user()->id);
        $tasklists = [];
        $allTasklists = TasklistModel::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')->get();

        foreach ($allTasklists as $list) {
            $tasklists[] = [
                'id' => $list->id,
                'name' => $list->name,
                'description' => $list->description,
            ];
        }

        return $tasklists;
    }

    private static function checkAuthAndRedirect()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }
}
