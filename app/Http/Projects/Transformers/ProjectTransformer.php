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
            'client_id'     => $project->client_id
        ];
    }
}