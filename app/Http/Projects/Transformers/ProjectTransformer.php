<?php

namespace App\Http\Projects\Transformers;

use App\Http\Projects\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    public function transform(Project $project)
    {
        return [
            'id'            => $project->id,
            'title'         => $project->title,
            'summary'       => $project->summary,
            'status'        => $project->status,
            'methodology'   => $project->methodology,
            'budget'        => $project->budget,
            'start_date'    => $project->start_date,
            'due_date'      => $project->due_date,
            'client'        => $project->client()->first(),
            'iterations'    => $project->iterations()->get(),
            'users'         => $project->users()->get()->map(function($user) {
                $user->project_manager = $user->pivot->project_manager;
                return $user;
            }),
        ];
    }
}