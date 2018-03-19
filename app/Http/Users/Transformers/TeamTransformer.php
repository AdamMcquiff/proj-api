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
            $user = User::where('id', '=', $item->user_id);
            if (!$users->contains($user)) {
                $newUser = $user->first();
                $newUser->day_rate = $item->day_rate;
                $newUser->role = $item->role;
                $users->push($newUser);
            }
        });

        return [
            'id'              => $team->id,
            'name'            => $team->name,
            'organisation_id' => $team->organisation_id,
            'users'           => $users
        ];
    }
}

