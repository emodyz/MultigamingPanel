<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\Articles\CreateArticle;
use App\Actions\Emodyz\Servers\CreateServer;
use App\Actions\Emodyz\Servers\EditServer;
use App\Http\Requests\Servers\CreateServerRequest;
use App\Http\Requests\Servers\EditServerRequest;
use App\Http\Resources\ModPack\ModPackResource;
use App\Http\Resources\Server\ServerModpackResource;
use App\Http\Resources\Server\ServerResource;
use App\Jobs\ProcessServerStatus;
use App\Models\Game;
use App\Models\Modpack;
use App\Models\Server;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Inertia\Inertia;
use function Symfony\Component\String\b;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|Response|\Inertia\Response
     */
    public function index(Request $request): Response|AnonymousResourceCollection|\Inertia\Response
    {
        $servers = Server::all();

        if ($request->wantsJson()) {
            return ServerResource::collection($servers);
        }

        $orderBy = $request->query('orderBy');

        $initialSearch = $request->query('search', '');

        $serversQuery = Server::query()
            ->with('modpacks')
            ->select('id', 'name', 'logo_path', 'ip', 'port', 'game_id', 'created_at')
            ->when($request->filled('search'), function ($query) use ($initialSearch) {
                $query->where('name', 'LIKE', '%' . $initialSearch . '%');
                $query->where('ip', 'LIKE', '%' . $initialSearch . '%');
            })
            ->when($request->filled('orderBy'), function ($query) use ($orderBy) {
                $orderByKey = $orderBy['key'];
                $orderByDirection = $orderBy['direction'];
                $query->orderBy($orderByKey, $orderByDirection);
            });

        $servers = $serversQuery
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->only(['search']));

        $totalItemCount = $servers->total();


        return Inertia::render('Servers/Index', compact('servers', 'initialSearch', 'totalItemCount'));
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
        $server = $store->storeNewServer($request->all());

        dispatch_now(new ProcessServerStatus($server));

        flash($request->get('name'), 'Your new server has ben successfully created!')->success();
        return redirect(route('servers.edit', $server));
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
     * @return \Inertia\Response
     */
    public function edit(Server $server): \Inertia\Response
    {
        $games = Game::all();

        $modPacks = Modpack::all();

        $server->modpacks;
        return Inertia::render('Servers/Edit', compact('server', 'games', 'modPacks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditServerRequest $request
     * @param Server $server
     * @param EditServer $editor
     * @return RedirectResponse
     */
    public function update(EditServerRequest $request, Server $server, EditServer $editor): RedirectResponse
    {
        $editor->editServer($server, $request->all());

        flash($request->get('name'),'This server has been successfully edited!')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Server $server
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Server $server): RedirectResponse
    {
        $server->delete();

        flash('Server Deleted',   '"'. $server->getAttribute('name') .'" has been successfully deleted!')->danger();
        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Server $server
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroyLogo(Server $server): RedirectResponse
    {
        $server->deleteLogo();

        flash('Server Logo', $server->getAttribute('name') . '\'s logo has been reset!')->warning();
        return back(303);
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
