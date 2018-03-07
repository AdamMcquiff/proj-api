<?php

namespace App\Http\Clients\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Http\Clients\Models\Client;
use App\Http\Clients\Requests\CreateClientRequest;
use App\Http\Clients\Requests\EditClientRequest;
use App\Http\Clients\Requests\ShowClientRequest;
use App\Http\Clients\Transformers\ClientTransformer;

class ClientController extends Controller
{
    public function index()
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
        $client = Client::where('id', '=', $id)->get();

        return $this->response->collection($client, new ClientTransformer);
    }

    public function store(CreateClientRequest $request)
    {
        $client = Client::create($request->only('name', 'organisation_id'));
        $client->organisation()->associate($request->input('organisation_id'));
        $client->save();

        return $this->response->item($client, new ClientTransformer);
    }

    public function update($id, EditClientRequest $request)
    {
        $client = Client::find($id);
        $client->fill($request->only('name', 'organisation_id'));
        $client->organisation()->associate($request->input('organisation_id'));
        $client->save();

        return $this->response->item($client, new ClientTransformer);
    }
}