<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Iteration;
use App\Http\Projects\Requests\CreateIterationRequest;
use App\Http\Projects\Requests\DestroyIterationRequest;
use App\Http\Projects\Requests\EditIterationRequest;
use App\Http\Projects\Requests\IndexIterationRequest;
use App\Http\Projects\Requests\ShowIterationRequest;
use App\Http\Projects\Transformers\IterationTransformer;
use App\Http\Users\Models\User;

class IterationController extends Controller
{
    public function index(IndexIterationRequest $request)
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
        $iteration = Iteration::where('id', '=', $id)->first();

        return $this->response->item($iteration, new IterationTransformer);
    }

    public function store(CreateIterationRequest $request)
    {
        $iteration = Iteration::create($request->only('title', 'project_id'));
        $iteration->save();

        return $this->response->item($iteration, new IterationTransformer);
    }

    public function update($id, EditIterationRequest $request)
    {
        $iteration = Iteration::find($id);
        $iteration->fill($request->only('title', 'summary', 'status', 'start_date', 'end_date'));
        $iteration->save();

        return $this->response->item($iteration, new IterationTransformer);
    }

    public function destroy($id, DestroyIterationRequest $request) {
        $iteration = Iteration::find($id);
        $iteration->delete();

        return $this->response->noContent();
    }
}