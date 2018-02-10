<?php

namespace App\Http\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserTeamRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day_rate'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Http\Users\Models\User', 'user_team_roles', 'user_id', 'role_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Http\Users\Models\UserRole', 'user_team_roles', 'user_id', 'role_id');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Http\Users\Models\Team', 'user_team_roles', 'user_id', 'team_id');
    }
}
