<?php

namespace App\Http\Users\Transformers;

use App\Http\Users\Models\User;
use App\Http\Users\Models\UserRole;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $teams = $user->teamsRolesUsers()->first()->teams()->get();
        $roles = $user->teamsRolesUsers()->first()->roles()->get();

        $teams = $teams->map(function ($team, $key) use ($roles) {
            $team['role'] = $roles[$key];
            return $team;
        });

        return [
            'id'        => $user->id,
            'name'      => $user->name,
            'username'  => $user->username,
            'email'     => $user->email,
            'projects'  => $user->projects()->get(),
            'teams'     => $teams,
        ];
    }
}