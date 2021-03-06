<?php

namespace App\Http\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'summary',
        'status',
        'methodology',
        'start_date',
        'due_date',
        'budget',
        'archived'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'projects';
    }

    public function client()
    {
        return $this->belongsTo('App\Http\Clients\Models\Client');
    }

    public function users()
    {
        return $this->belongsToMany('App\Http\Users\Models\User')
            ->withPivot('project_manager')
            ->withTimestamps();
    }

    public function iterations()
    {
        return $this->hasMany('App\Http\Projects\Models\Iteration')
            ->with('tasks');
    }
}
