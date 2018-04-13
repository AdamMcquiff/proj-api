<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Project;
use App\Http\Projects\Requests\SearchRequest;
use App\Http\Projects\Transformers\ProjectTransformer;

class SearchController extends Controller
{
    public function search($terms, SearchRequest $request)
    {
        $projects = Project::search($terms)->get();
        $projects = $this->response->collection($projects, new ProjectTransformer);

        return $projects;
    }
}