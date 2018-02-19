<?php

namespace App\Http\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'permissions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'pivot',
        'updated_at',
        'created_at'
    ];

    public function teamsRolesUsers()
    {
        return $this->hasMany('App\Http\Users\Models\UserTeamRole');
    }
}
