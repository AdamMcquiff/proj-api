<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Task;
use App\Http\Projects\Transformers\TaskTransformer;
use App\Http\Users\Models\Organisation;
use App\Http\Users\Models\User;
use App\Http\Users\Requests\CreateOrganisationRequest;
use App\Http\Users\Requests\EditOrganisationRequest;
use App\Http\Users\Requests\JoinOrganisationRequest;
use App\Http\Users\Transformers\OrganisationTransformer;

class TaskController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $tasks = Task::where('reporter_id', $user->id)
            ->orWhere('assignee_id', $user->id)
            ->get();

        return $this->response->item($tasks, new TaskTransformer);
    }

    public function show($id)
    {
        $task = Task::where('id', $id)
            ->where(function ($q) {
                $q->where(function ($query) {
                    $query->where('reporter_id', auth()->user()->id);
                })
                ->orWhere(function ($query) {
                    $query->where('assignee_id', auth()->user()->id);
                });
            })
            ->get();

        return $this->response->item($task, new TaskTransformer);
    }

    public function store(CreateOrganisationRequest $request)
    {
        $organisation = Organisation::create($request->all());
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