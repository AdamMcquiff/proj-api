<?php

namespace App\Http\Users\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Users\Models\Team;
use App\Http\Users\Models\User;
use App\Http\Users\Models\UserTeamRole;
use App\Http\Users\Requests\CreateTeamRequest;
use App\Http\Users\Requests\EditTeamRequest;
use App\Http\Users\Transformers\TeamTransformer;

class TeamController extends Controller
{
    public function index()
    {
        $user_roles = User::find(auth()->user()->id)
            ->teams_roles_users()
            ->get();

        $teams = collect();
        foreach ($user_roles as $role) {
            $team = Team::find($role->team_id);
            if (!$teams->contains($team)) $teams->push($team);
        }

        return $this->response->collection($teams, new TeamTransformer);
    }

    public function show($id)
    {
        $user_role = User::find(auth()->user()->id)
            ->teams_roles_users()
            ->where('team_id', $id)
            ->get();

        $team = Team::find($user_role->first()->team_id);

        return $this->response->item($team, new TeamTransformer);
    }

    public function store(CreateTeamRequest $request)
    {
        $team = Team::create($request->only('name', 'organisation_id'));
        $users = $request->input('users');

        foreach ($users as $user) {
            UserTeamRole::create([
                'day_rate' => $user['day_rate'],
                'user_id'  => $user['id'],
                'team_id'  => $team->id,
                'role_id'  => 1
            ]);
        }

        return $this->response->item($team, new TeamTransformer);
    }

    public function update($id, EditTeamRequest $request)
    {
        $team = Team::find($id);
        $team->fill($request->only('name'));
        $users = $request->input('users');

        foreach ($users as $user) {
            $user_role = UserTeamRole::where([['team_id', '=', $team->id], ['user_id', '=', $user['id']]])->first();
            if (is_null($user_role)) {
                UserTeamRole::create([
                    'day_rate' => $user['day_rate'],
                    'user_id'  => $user['id'],
                    'team_id'  => $team->id,
                    'role_id'  => 1
                ]);
            } else {
                $user_role->users()->sync($user['id']);
                $user_role->day_rate = $user['day_rate'];
                $user_role->save();
            }
        }

        return $this->response->item($team, new TeamTransformer);
    }
}