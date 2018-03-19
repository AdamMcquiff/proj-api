<?php

namespace App\Http\Clients\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Clients\Models\Client;
use App\Http\Clients\Requests\CreateClientRequest;
use App\Http\Clients\Requests\DestroyClientRequest;
use App\Http\Clients\Requests\EditClientRequest;
use App\Http\Clients\Requests\IndexClientRequest;
use App\Http\Clients\Requests\ShowClientRequest;
use App\Http\Clients\Transformers\ClientTransformer;

class ClientController extends Controller
{
    public function index(IndexClientRequest $request)
    {
        $clients = Client::all();

        $filtered = $clients->filter(function ($item) {
            $organisations = auth()->user()->organisations()->filter(function($organisation) use ($item) {
                return $organisation->id === $item->organisation_id;
            });
            return !$organisations->isEmpty();
        })->values();

        return $this->response->collection($filtered, new ClientTransformer);
    }

    public function show($id, ShowClientRequest $request)
    {
        $client = Client::where('id', '=', $id)->first();

        return $this->response->item($client, new ClientTransformer);
    }

    public function store(CreateClientRequest $request)
    {
        $organisation_id = auth()->user()->organisations()->first()->id;
        $data = array_merge($request->only('name'), ['organisation_id' => $organisation_id]);

        $client = Client::create($data);
        $client->organisation()
            ->associate($organisation_id)
            ->save();

        return $this->response->item($client, new ClientTransformer);
    }

    public function update($id, EditClientRequest $request)
    {
        $client = Client::find($id);
        $client->fill($request->only('name', 'summary', 'organisation_id'));
        if ($request->input('organisation_id')) {
            $client->organisation()
                ->associate($request->input('organisation_id'));
        }
        $client->save();

        return $this->response->item($client, new ClientTransformer);
    }

    public function destroy($id, DestroyClientRequest $request)
    {
        $client = Client::find($id);
        $client->delete();

        return $this->response->noContent();
    }
}