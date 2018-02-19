<?php

namespace App\Http\Users\Transformers;

use App\Http\Users\Models\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    public function transform(Team $team)
    {
        return [
            'id'              => $team->id,
            'name'            => $team->name,
            'organisation_id' => $team->organisation_id,
            'users'           => $team->teams_roles_users()->get()
        ];
    }
}