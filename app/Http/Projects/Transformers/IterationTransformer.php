<?php

namespace App\Http\Projects\Transformers;

use App\Http\Projects\Models\Iteration;
use League\Fractal\TransformerAbstract;

class IterationTransformer extends TransformerAbstract
{
    public function transform(Iteration $iteration)
    {
        return [
            'id'         => $iteration->id,
            'title'      => $iteration->title,
            'summary'    => $iteration->summary,
            'status'     => $iteration->status,
            'start_date' => $iteration->start_date,
            'due_date'   => $iteration->end_date,
            'project_id' => $iteration->project_id,
            'tasks'      => $iteration->tasks()->get()
        ];
    }
}