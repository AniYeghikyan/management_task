<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class TaskController extends Controller
{
    public function getTasksPage()
    {
        return view(
            'tasks',
            [
                'tasks' => Task::orderBy('created_at', 'asc')->where('is_archive', "off")->get()
            ],
            ['users' => User::all()]
        );
    }

    public function addTask(Request $request, Authenticatable $auth)
    {
        // $validator = Validator::make($request->all(), [
        //   'name' => 'required|max:255',
        // ]);

        // if ($validator->fails()) {
        //   return redirect('/')
        //     ->withInput()
        //     ->withErrors($validator);
        // }

        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->created_by = $auth->name;
        $task->assigned_to = $request->assigned_to;
        $task->task_status = "New";
        $task->is_archive = "off";

        $task->save();

        return redirect('/');
    }

    public function editTask($id, Request $req)
    {
        $task = Task::find($id);

        $task->name = $req->input('name_' . $id);
        $task->description = $req->input('description_' . $id);
        $task->assigned_to = $req->input('assigned_to_' . $id);
        if ($req->input('is_archive_' . $id) === "on") {
            $task->is_archive = $req->input('is_archive_' . $id);
        }

        $task->task_status = $req->input('task_status_' . $id);

        $task->save();

        return redirect('/');
        // return redirect()->route('contact-data-one', $id)->with('success', 'The message was updated');
    }

    public function deleteTask($id)
    {
        Task::findOrFail($id)->delete();

        return redirect('/');
    }
}
