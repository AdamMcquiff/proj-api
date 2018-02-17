<?php

namespace App\Http\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
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
        'due_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function iteration()
    {
        return $this->belongsTo('App\Http\Projects\Models\Iteration');
    }

    public function reporter()
    {
        return $this->belongsTo('App\Http\Users\Models\User','id','reporter_id');
    }

    public function assignee()
    {
        return $this->belongsTo('App\Http\Users\Models\User','id','assignee_id');
    }
}
