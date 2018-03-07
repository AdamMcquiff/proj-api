<?php

namespace App\Http\Clients\Transformers;

use App\Http\Clients\Models\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    public function transform(Client $client)
    {
        return [
            'id'           => $client->id,
            'name'         => $client->name,
            'organisation' => $client->organisation()->get(),
        ];
    }
}