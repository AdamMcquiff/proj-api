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
        'user_id',
        'team_id',
        'role_id',
        'day_rate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'updated_at',
        'created_at'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Http\Users\Models\User', 'user_team_roles', 'id', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Http\Users\Models\UserRole', 'user_team_roles', 'id', 'role_id');
    }

    public function teams()
    {
        return $this->belongsTo('App\Http\Users\Models\Team', 'user_team_roles', 'id', 'role_id');
    }
}
