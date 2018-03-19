<?php

namespace App\Http\Users\Models;

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
        'read',
        'comment_id',
        'sender_id',
        'recipient_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function comment()
    {
        return $this->belongsTo('App\Http\Projects\Models\Comment');
    }

    public function recipient()
    {
        return $this->belongsTo('App\Http\Users\Models\User','id','recipient_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Http\Users\Models\User','id','sender_id');
    }
}
