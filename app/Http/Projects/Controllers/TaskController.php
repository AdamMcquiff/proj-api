<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Task;
use App\Http\Projects\Requests\CreateTaskRequest;
use App\Http\Projects\Requests\EditTaskRequest;
use App\Http\Projects\Requests\ShowTaskRequest;
use App\Http\Projects\Transformers\TaskTransformer;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('reporter_id', auth()->user()->id)
            ->orWhere('assignee_id', auth()->user()->id)
            ->get();

        return $this->response->collection($tasks, new TaskTransformer);
    }

    public function show($id, ShowTaskRequest $request)
    {
        $task = Task::where('id', '=', $id)->first();

        return $this->response->item($task, new TaskTransformer);
    }

    public function store(CreateTaskRequest $request)
    {
        $task = Task::create($request->only('title', 'iteration_id'));
        return $this->response->item($task, new TaskTransformer);
    }

    public function update($id, EditTaskRequest $request)
    {
        $task = Task::find($id);
        $task->fill(
            $request->only('title', 'summary', 'due_date', 'status', 'reporter_id', 'assignee_id', 'iteration_id')
        )->save();

        return $this->response->item($task, new TaskTransformer);
    }

    public function destroy($id) {
        $task = Task::find($id);
        $task->delete();

        return $this->response->noContent();
    }
}