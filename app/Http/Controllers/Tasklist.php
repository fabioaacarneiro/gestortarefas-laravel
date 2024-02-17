<?php

namespace App\Http\Controllers;

use App\Models\TasklistModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Tasklist extends Controller
{

    public function index()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return redirect()->route('tasklist');
    }

    public function lists()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

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
            'datatables' => false,
            'user_name' => Auth::user()->name,
            'user_level' => $lvl,
            'user_experience' => $exp,
            'tasklists' => Tasklist::getLists(),
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
            'description' => 'max:1000|nullable',
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

        return redirect()->route('tasklist');
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
        };

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
            'datatables' => false,
            'user_name' => Auth::user()->name,
            'tasklists' => $tasklists,
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
}
