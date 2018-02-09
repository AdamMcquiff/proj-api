<?php

namespace App\Http\Users\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
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
        return $this->belongsTo('App\Http\Users\Models\Organisation');
    }

    public function users()
    {
        return $this->belongsToMany('App\Http\Users\Models\User', 'user_team_roles');
    }
}
