<?php

namespace App\Http\Users\Models;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function admins()
    {
        return $this->belongsToMany('App\Http\Users\Models\User','organisation_admins',  'organisation_id', 'user_id');
    }
}
