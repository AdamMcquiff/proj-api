<?php

namespace App\Http\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    public function teams_roles_users()
    {
        return $this->hasMany('App\Http\Users\Models\UserTeamRole');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Http\Projects\Models\Project');
    }

    public function reported_tasks()
    {
        return $this->hasMany('App\Http\Projects\Models\Task', 'reporter_id');
    }

    public function assigned_tasks()
    {
        return $this->hasMany('App\Http\Projects\Models\Task', 'assignee_id');
    }

    public function sent_notifications()
    {
        return $this->hasMany('App\Http\Users\Models\Notification', 'sender_id');
    }

    public function received_notifications()
    {
        return $this->hasMany('App\Http\Users\Models\Notification', 'recipient_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
