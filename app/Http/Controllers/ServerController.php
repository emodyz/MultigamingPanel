<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $servers = Server::all();

        fetch_servers_status($servers)->each(function ($server, $key) use ($servers) {
            $servers[$key]['status'] = $server;
        });

        if ($request->wantsJson()) {
            return response()->json($servers);
        }

        return view('servers.index', ['servers' => $servers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('servers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Server $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Server $server
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Server $server)
    {
        return view('servers.edit', ['server' => $server]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Server $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Server $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        $server->delete();
        return response()->noContent();
    }

    public function status(Request $request, $serverId)
    {
        $server = Server::findOrFail($serverId);

        return fetch_server_status($server);
    }
}
