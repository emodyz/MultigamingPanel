<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\Articles\CreateArticle;
use App\Actions\Emodyz\Servers\CreateServer;
use App\Http\Requests\Servers\CreateServerRequest;
use App\Http\Resources\Server\ServerModpackResource;
use App\Http\Resources\Server\ServerResource;
use App\Models\Game;
use App\Models\Modpack;
use App\Models\Server;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        $servers = Server::all();

        return ServerResource::collection($servers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        $games = Game::all();

        $modPacks = Modpack::all();

        return Inertia::render('Servers/Create', compact('games', 'modPacks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateServerRequest $request
     * @param CreateServer $store
     * @return RedirectResponse
     */
    public function store(CreateServerRequest $request, CreateServer $store): RedirectResponse
    {
        $store->storeNewServer($request->all());

        flash($request->get('name'), 'Your new server has ben successfully created!')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Server $server
     * @return ServerResource|Response
     */
    public function show(Server $server)
    {
        return ServerResource::make($server);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Server $server
     * @return Response
     */
    public function edit(Server $server)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Server $server
     * @return Response
     */
    public function update(Request $request, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Server $server
     * @return Response
     */
    public function destroy(Server $server)
    {
        //
    }

    /**
     * @param Server $server
     * @return AnonymousResourceCollection
     */
    public function modpacks(Server $server)
    {
        return ServerModpackResource::collection($server->modpacks);
    }
}
