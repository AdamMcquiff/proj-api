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
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'created_at', 'updated_at', 'project_id'
    ];

    public function project()
    {
        return $this->belongsTo('App\Http\Projects\Models\Project');
    }
}
