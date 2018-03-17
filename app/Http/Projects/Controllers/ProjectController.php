<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Project;
use App\Http\Projects\Requests\CreateProjectRequest;
use App\Http\Projects\Requests\EditProjectRequest;
use App\Http\Projects\Requests\ShowProjectRequest;
use App\Http\Projects\Transformers\ProjectTransformer;
use App\Http\Users\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = User::find(auth()->user()->id)
            ->projects()
            ->get();

        return $this->response->collection($projects, new ProjectTransformer);
    }

    public function show($id, ShowProjectRequest $request)
    {
        $project = Project::where('id', '=', $id)->first();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->only('title', 'summary', 'status', 'methodology', 'budget', 'client_id'));
        $users = $request->input('users') ? $request->input('users') : [];
        array_push($users, auth()->user()->id);
        $project->users()->sync($users, false);
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function update($id, EditProjectRequest $request)
    {
        $project = Project::find($id);
        $project->fill($request->only('title', 'summary', 'status', 'methodology', 'start_date', 'due_date', 'budget', 'client_id'));
        $project->users()->sync($request->input('users'), false);
        $project->client()->associate($request->input('client_id'));
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function destroy($id) {
        $project = Project::find($id);
        $project->delete();

        return $this->response->noContent();
    }

    public function archive($id) {
        $project = Project::find($id);
        $project->fill(["archived" => 1]);
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }
}