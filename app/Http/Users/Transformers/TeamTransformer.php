<?php

namespace App\Http\Users\Transformers;

use App\Http\Users\Models\Team;
use App\Http\Users\Models\User;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    public function transform(Team $team)
    {
        $users = collect();

        $team->teams_roles_users()->get()->each(function($item) use ($users) {
            $user = User::find($item->user_id);
            if (!$users->contains($user)) {
                // TODO: get day rate / role
                $users->push($user->get());
            }
        });

        return [
            'id'              => $team->id,
            'name'            => $team->name,
            'organisation_id' => $team->organisation_id,
            'users'           => $users[0]
        ];
    }
}

