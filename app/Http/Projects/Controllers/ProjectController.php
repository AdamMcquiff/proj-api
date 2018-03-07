<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Project;
use App\Http\Projects\Requests\CreateProjectRequest;
use App\Http\Projects\Requests\EditProjectRequest;
use App\Http\Projects\Transformers\ProjectTransformer;
use App\Http\Users\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = User::find(auth()->user()->id)
            ->projects()
            ->get();

        return $this->response->item($projects, new ProjectTransformer);
    }

    public function show($id)
    {
        $project = User::find(auth()->user()->id)
            ->projects()
            ->where('project_id', $id)
            ->get();

        return $this->response->collection($project, new ProjectTransformer);
    }

    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->only('title', 'summary', 'status', 'methodology', 'budget', 'client_id'));
        $project->users()->sync($request->input('users'), false);
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function update($id, EditProjectRequest $request)
    {
        $project = Project::find($id);
        $project->fill($request->only('title', 'summary', 'status', 'methodology', 'budget', 'client_id'));
        $project->users()->sync($request->input('users'), false);
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }
}