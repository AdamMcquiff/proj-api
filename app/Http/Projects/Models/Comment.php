<?php

namespace App\Http\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'time_sent',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'created_at', 'updated_at', 'task_id'
    ];

    public function task()
    {
        return $this->belongsTo('App\Http\Projects\Models\Task');
    }
}
