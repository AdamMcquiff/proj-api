<?php

namespace App\Http\Projects\Transformers;

use App\Http\Projects\Models\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    public function transform(Task $task)
    {
        return [
            'id'            => $task->id,
            'title'         => $task->title,
            'summary'       => $task->summary,
            'status'        => $task->status,
            'due_date'      => $task->due_date,
            'reporter_id'   => $task->reporter_id,
            'assignee_id'   => $task->assignee_id,
            'iteration_id'  => $task->assignee_id
        ];
    }
}