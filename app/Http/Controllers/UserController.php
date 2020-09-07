<?php
namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller
{

    public function searchByUser(Request $request, $id){

    }

    public function getTasksPage()
    {
        return view(
            'tasks',
            [
                'tasks' => Task::orderBy('created_at', 'asc')->get()
            ],
            ['users' => User::all()]
        );
    }



    public function editTask($id, Request $req) {
        $task = Task::find($id);
        $task->name = $req->input('name_'.$id);
        $task->assigned_to = $req->input('assigned_to_'.$id);
        $task->task_status = $req->input('task_status_'.$id);

        $task->save();

        return redirect('/');
        // return redirect()->route('contact-data-one', $id)->with('success', 'The message was updated');
    }

    public  function deleteTask($id) {
        Task::findOrFail($id)->delete();

        return redirect('/');
    }
}
