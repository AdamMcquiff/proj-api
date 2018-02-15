<?php

namespace App\Http\Users\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Users\Models\Organisation;
use App\Http\Users\Models\User;
use App\Http\Users\Requests\CreateOrganisationRequest;
use App\Http\Users\Requests\EditOrganisationRequest;
use App\Http\Users\Transformers\OrganisationTransformer;

class OrganisationController extends Controller
{
    public function index()
    {
        $organisations = User::find(auth()->user()->id)
            ->administrated_organisations()
            ->get();

       return $this->response->item($organisations, new OrganisationTransformer);
    }

    public function show($id)
    {
        $organisation = User::find(auth()->user()->id)
            ->administrated_organisations()
            ->where('organisation_id', $id)
            ->get();

        return $this->response->item($organisation, new OrganisationTransformer);
    }

    public function store(CreateOrganisationRequest $request)
    {
        $organisation = Organisation::create($request->all());
        return $organisation;
    }

    public function update($id, EditOrganisationRequest $request)
    {
        $organisation = User::find(auth()->user()->id)
            ->administrated_organisations()
            ->where('organisation_id', $id)
            ->get();

        if ($organisation->isEmpty())
            return response(null, 404);

        $organisation = Organisation::find($id);
        $organisation->name = $request->json('name');
        $organisation->save();
        return $organisation;
    }
}