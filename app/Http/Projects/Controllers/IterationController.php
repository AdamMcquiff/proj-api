<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Iteration;
use App\Http\Projects\Models\Project;
use App\Http\Projects\Requests\CreateProjectRequest;
use App\Http\Projects\Requests\EditProjectRequest;
use App\Http\Projects\Requests\ShowIterationRequest;
use App\Http\Projects\Transformers\IterationTransformer;
use App\Http\Users\Models\User;

class IterationController extends Controller
{
    public function index()
    {
        $projects = User::find(auth()->user()->id)->projects();

        $iterations = collect();

        $projects->each(function ($project) use ($iterations) {
            $project->iterations()->get()->each(function ($iteration) use ($iterations) {
                $iterations->push($iteration);
            });
        });

        return $this->response->collection($iterations, new IterationTransformer);
    }

    public function show($id, ShowIterationRequest $request)
    {
        $iteration = Iteration::find($id)->get();

        return $this->response->collection($iteration, new IterationTransformer);
    }

    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->only('title', 'summary', 'status', 'methodology', 'budget', 'client_id'));
        $project->users()->sync($request->input('users'), false);
        $project->save();

        return $this->response->item($project, new IterationTransformer);
    }

    public function update($id, EditProjectRequest $request)
    {
        $project = Project::find($id);
        $project->fill($request->only('title', 'summary', 'status', 'methodology', 'budget', 'client_id'));
        $project->users()->sync($request->input('users'), false);
        $project->save();

        return $this->response->item($project, new IterationTransformer);
    }
}