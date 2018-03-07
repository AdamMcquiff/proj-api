<?php

namespace App\Http\Projects\Transformers;

use App\Http\Projects\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    public function transform(Project $project)
    {
        $tasks = collect();

        $project->iterations()->get()->each(function ($iteration) use ($tasks) {
            $iteration->tasks()->get()->each(function ($task) use ($tasks) {
                $tasks->push($task);
            });
        });

        return [
            'id'            => $project->id,
            'title'         => $project->title,
            'summary'       => $project->summary,
            'status'        => $project->status,
            'methodology'   => $project->methodology,
            'budget'        => $project->budget,
            'start_date'    => $project->start_date,
            'due_date'      => $project->due_date,
            'client_id'     => $project->client_id,
            'iterations'    => $project->iterations()->get(),
            'tasks'         => $tasks
        ];
    }
}