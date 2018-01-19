<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'pivot'
    ];

    public function organisation()
    {
        return $this->belongsTo('App\Organisation');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_team_roles');
    }
}
