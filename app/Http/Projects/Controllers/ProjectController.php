<?php

namespace App\Http\Projects\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Projects\Models\Project;
use App\Http\Projects\Notifications\SendProjectInvitation;
use App\Http\Projects\Requests\AcceptProjectInvitationRequest;
use App\Http\Projects\Requests\ArchiveProjectRequest;
use App\Http\Projects\Requests\CreateProjectRequest;
use App\Http\Projects\Requests\DestroyProjectRequest;
use App\Http\Projects\Requests\EditProjectRequest;
use App\Http\Projects\Requests\IndexProjectRequest;
use App\Http\Projects\Requests\SendProjectInvitationRequest;
use App\Http\Projects\Requests\ShowProjectRequest;
use App\Http\Projects\Transformers\ProjectTransformer;
use App\Http\Users\Models\User;

class ProjectController extends Controller
{
    public function index(IndexProjectRequest $request)
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
        $users = $request->input('users') ? $request->input('users') : [];
        $project = Project::create(
            $request->only('title', 'summary', 'status', 'methodology', 'budget', 'client_id')
        );
        $project->users()
            ->sync(array_merge($users, [auth()->user()->id]), false);
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function update($id, EditProjectRequest $request)
    {
        $project = Project::find($id);
        $project->fill(
            $request->only(
                'title', 'summary', 'status', 'methodology', 'start_date', 'due_date', 'budget', 'client_id'
            )
        );
        $project->users()->sync($request->input('users'), false);
        $project->client()->associate($request->input('client_id'));
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function destroy($id, DestroyProjectRequest $request)
    {
        $project = Project::find($id);
        $project->delete();

        return $this->response->noContent();
    }

    public function archive($id, ArchiveProjectRequest $request)
    {
        $project = Project::find($id);
        $project->fill(["archived" => $request->archive]);
        $project->save();

        return $this->response->item($project, new ProjectTransformer);
    }

    public function invite($id, SendProjectInvitationRequest $request)
    {
        $recipient = User::where('email', '=', $request->input('email'))->first();

        if (is_null($recipient)) return response(null, 404);

        $recipient->notify(new SendProjectInvitation($recipient->id, $id));

        return $this->response->noContent();
    }

    public function acceptInvitation(AcceptProjectInvitationRequest $request)
    {
        $user = User::find($request->user_id);
        $project = Project::find($request->project_id);
        $project->users()->sync([$user->id], false);

        return 'Invite accepted';
    }
}