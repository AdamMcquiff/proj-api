<?php

namespace App\Http\Users\Transformers;

use App\Http\Users\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'        => $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
            'password'  => $user->password,
            'teams'     => $user->teams()->get()
        ];
    }
}