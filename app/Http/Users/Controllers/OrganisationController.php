<?php

namespace App\Http\Users\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Users\Models\Organisation;
use App\Http\Users\Models\Team;
use App\Http\Users\Models\User;
use App\Http\Users\Models\UserTeamRole;
use App\Http\Users\Requests\CreateOrganisationRequest;
use App\Http\Users\Requests\EditOrganisationRequest;
use App\Http\Users\Requests\IndexOrganisationRequest;
use App\Http\Users\Requests\JoinOrganisationRequest;
use App\Http\Users\Requests\ShowOrganisationRequest;
use App\Http\Users\Transformers\OrganisationTransformer;

class OrganisationController extends Controller
{
    public function index(IndexOrganisationRequest $request)
    {
        $organisations = User::find(auth()->user()->id)
            ->administrated_organisations()
            ->get();

       return $this->response->item($organisations, new OrganisationTransformer);
    }

    public function show($id, ShowOrganisationRequest $request)
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

        // Create a demo team for the user
        $team = Team::create([
            'name' => 'Sample Team',
            'organisation_id' => $organisation->id
        ]);

         UserTeamRole::create([
            'user_id' => auth()->user()->id,
            'team_id' => $team->id,
            'role_id' => 3
        ]);

        return $this->response->item($organisation, new OrganisationTransformer);
    }

    public function update($id, EditOrganisationRequest $request)
    {
        $organisation = Organisation::find($id);
        $organisation->name = $request->json('name');
        $organisation->save();

        return $this->response->item($organisation, new OrganisationTransformer);
    }

    public function join($id, JoinOrganisationRequest $request)
    {
        $organisation = Organisation::find($id);
        $organisation->admins()->sync(auth()->user()->id, false);
        $organisation->save();

        return $this->response->item($organisation, new OrganisationTransformer);
    }
}