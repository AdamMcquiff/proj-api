<?php

namespace App\Http\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
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
        'methodology',
        'budget'
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
        return $this->belongsToMany('App\Http\Users\Models\User');
    }
}
