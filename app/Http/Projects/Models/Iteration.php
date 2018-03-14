<?php

namespace App\Http\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class Iteration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'summary',
        'status',
        'start_date',
        'end_date',
        'project_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function project()
    {
        return $this->belongsTo('App\Http\Projects\Models\Project');
    }

    public function tasks()
    {
        return $this->hasMany('App\Http\Projects\Models\Task');
    }
}
