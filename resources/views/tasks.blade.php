@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::guest())
            <div>
                <h1>You need to Login or Register</h1>
            </div>
        @else
            <div class="col-sm-offset-2 col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        New Task
                    </div>

                    <div class="panel-body">
                        <!-- Display Validation Errors -->


                    <!-- New Task Form -->
                        <form action="{{ url('task')}}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                            <div class="form-group">
                                <label for="task-name" class="col-sm-3 control-label">Task Name</label>

                                <div class="col-sm-6">
                                    <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                                </div>
                            </div>

                            <!-- Task Desc -->
                            <div class="form-group">
                                <label for="company-content" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-6">
              <textarea placeholder="Enter description"
                        style="resize: vertical"
                        id="company-content"
                        name="description"
                        rows="5" spellcheck="false"
                        class="form-control autosize-target text-left">


                                          </textarea>
                                </div>
                            </div>

                            <!-- Assigned To -->
                            <div class="form-group">
                                <label for="task-assigned-to" class="col-sm-3 control-label">Assigned To</label>

                                <div class="col-sm-6">
                                    <select name="assigned_to" class="form-control" id="task-assigned-to">
                                        @foreach ($users as $user)
                                            <option>{{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Add Task Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-btn fa-plus"></i>Add Task
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Current Tasks -->
                @if (count($tasks) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Current Tasks
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                <th>Task Name</th>
                                <th>Created By</th>
                                <th>Assigned To</th>
                                <th>Task Status</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td class="table-text">
                                            <div>{{ $task->name }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $task->created_by }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $task->assigned_to }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $task->task_status }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $task->description }}</div>
                                        </td>
                                        <!-- Task Edit Button -->
                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal_{{ $task->id }}">Edit</button>
                                        </td>
                                        <!-- Task Invite  -->
                                        <td>
                                            <a class=" btn btn-success" type="button" href="{{route('invite')}}">Invite</a>

                                        </td>
                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- Modal -->
                            @foreach ($tasks as $task)
                                <div class="modal fade" id="myModal_{{$task->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update-task',$task->id)}}" method='POST'>
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label class="control-label">Task Name</label>
                                                        <input type="text" class="form-control" name="name_{{ $task->id }}" value="{{ $task->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="company-content" class="control-label">Description</label>

                                                        <textarea placeholder="Enter description"
                                                                  style="resize: vertical"
                                                                  id="company-content"
                                                                  name="description_{{ $task->id }}"
                                                                  rows="5" spellcheck="false"
                                                                  class="form-control autosize-target text-left">

                                            {{ $task->description }}
                                          </textarea>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Assigned To</label>
                                                        <select name="assigned_to_{{ $task->id }}" class="form-control" value="{{ $task->assigned_to }}">
                                                            @foreach ($users as $user)
                                                                <option {{ ($task->assigned_to == $user->email) ? "selected": ""}}>{{ $user->email }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Task Status</label>
                                                        <select name="task_status_{{ $task->id }}" class="form-control" >
                                                            <option value="New" {{ ($task->task_status == "New") ? "selected": ""}}>New</option>
                                                            <option value="Pending" {{ ($task->task_status == "Pending") ? "selected": ""}}>Pending</option>
                                                            <option value="Completed" {{ ($task->task_status == "Completed") ? "selected": ""}}>Completed</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Archive</label>
                                                        <input type="checkbox" data-toggle="toggle" name="is_archive_{{ $task->id }}">
                                                    </div>
                                                    <hr>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-btn fa-save" data-dismiss="modal"></i>Save
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

@endsection
