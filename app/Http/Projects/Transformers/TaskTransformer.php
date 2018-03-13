<?php

namespace App\Http\Projects\Transformers;

use App\Http\Projects\Models\Iteration;
use App\Http\Projects\Models\Task;
use App\Http\Users\Models\User;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    public function transform(Task $task)
    {
        $iteration = Iteration::where('id', '=', $task->iteration_id)->first();
        $reporter = User::where('id', '=', $task->reporter_id)->first();
        $assignee = User::where('id', '=', $task->assignee_id)->first();

        return [
            'id'            => $task->id,
            'title'         => $task->title,
            'summary'       => $task->summary,
            'status'        => $task->status,
            'due_date'      => $task->due_date,
            'iteration'     => $iteration,
            'reporter'      => $reporter,
            'assignee'      => $assignee,
        ];
    }
}