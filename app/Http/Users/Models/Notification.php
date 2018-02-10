<?php

namespace App\Http\Projects\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'read'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'created_at', 'updated_at', 'comment_id', 'sender_id', 'recipient_id'
    ];

    public function comment()
    {
        return $this->belongsTo('App\Http\Projects\Models\Comment');
    }
}
