<?php

namespace App\Http\Users\Transformers;

use App\Http\Users\Models\User;
use App\Http\Users\Models\UserRole;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
//        $teams = $user->teams_roles_users()->first()->teams()->get();
//        $roles = $user->teams_roles_users()->first()->roles()->get();
//
//        $teams = $teams->map(function ($team, $key) use ($roles, $user) {
//            $team['day_rate'] = $user->teams_roles_users()->get()[$key]->day_rate;
//            $team['role'] = $roles[$key];
//            return $team;
//        });

        return [
            'id'                     => $user->id,
            'name'                   => $user->name,
            'username'               => $user->username,
            'email'                  => $user->email,
//            'projects'               => $user->projects()->with('client')->get(),
//            'reported_tasks'         => $user->reported_tasks()->get(),
//            'assigned_tasks'         => $user->assigned_tasks()->get(),
//            'sent_notifications'     => $user->sent_notifications()->get(),
//            'received_notifications' => $user->sent_notifications()->get(),
//            'teams'                  => $teams,
        ];
    }
}