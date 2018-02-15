<?php

namespace App\Http\Users\Transformers;

use App\Http\Users\Models\Organisation;
use League\Fractal\TransformerAbstract;

class OrganisationTransformer extends TransformerAbstract
{
    public function transform(Organisation $organisation)
    {
        return [
            'id'   => $organisation->id,
            'name' => $organisation->name,
        ];
    }
}