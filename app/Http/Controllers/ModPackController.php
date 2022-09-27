<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\ModPacks\CreateModPack;
use App\Actions\Emodyz\ModPacks\EditModPack;
use App\Events\ModPack\ModPackUpdateRequested;
use App\Exceptions\ModPackException;
use App\Http\Requests\ModPacks\CreateModPackRequest;
use App\Http\Requests\ModPacks\EditModPackRequest;
use App\Http\Resources\ModPack\ModPackResource;
use App\Models\Game;
use App\Models\Modpack;
use Exception;
use App\Models\Server;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\ResponseFactory;

class ModPackController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:modpacks-index', ['only' => ['index']]);

    $this->middleware('can:modpacks-create', ['only' => ['create', 'store']]);

    $this->middleware('can:modpacks-edit', ['only' => ['edit', 'update']]);

    $this->middleware('can:modpacks-destroy', ['only' => ['destroy']]);

    $this->middleware('can:modpacks-update', ['only' => ['showUpdate', 'startUpdate', 'cancelUpdate']]);
  }

  /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|Response|\Inertia\Response|ResponseFactory
     */
    public function index(Request $request): Response|AnonymousResourceCollection|\Inertia\Response|ResponseFactory
    {
        $orderBy = $request->query('orderBy');

        $initialSearch = $request->query('search', '');

        $modpacksQuery = Modpack::query()
            ->with(['servers', 'game'])
            ->select('id', 'name', 'game_id', 'path', 'manifest_info', 'manifest_last_update')
            ->when($request->filled('search'), function ($query) use ($initialSearch) {
                $query->where('name', 'LIKE', '%' . $initialSearch . '%');
            })
            ->when($request->filled('orderBy'), function ($query) use ($orderBy) {
                $orderByKey = $orderBy['key'];
                $orderByDirection = $orderBy['direction'];
                $query->orderBy($orderByKey === 'roleName' ? 'role' : $orderByKey, $orderByDirection);
            });

        $modpacks = $modpacksQuery
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->only(['search']));

        $totalItemCount = $modpacks->total();

        if ($request->wantsJson()) {
            return ModPackResource::collection($modpacks);
        }

        $servers = Server::all();

        $games = Game::all();

        return Inertia::render('ModPacks/Index', compact('modpacks', 'games', 'servers', 'initialSearch', 'totalItemCount'));
    }

  /**
   * Store a newly created resource in storage.
   *
   * @param CreateModPackRequest $request
   * @param CreateModPack $store
   * @return ModPackResource|Application|\Illuminate\Contracts\Routing\ResponseFactory|RedirectResponse|Response
   * @throws ModPackException
   */
    public function store(CreateModPackRequest $request, CreateModPack $store)
    {
      $modPack = $store->storeNewModPack($request->all());

      if ($request->wantsJson()) {
        return response()->noContent(Response::HTTP_CREATED);
      }

      flash($request->get('name'), 'Your new ModPack has been successfully created!')->success();
      return redirect(route('modpacks.update.show', $modPack));
    }

    /**
     * @param Request $request
     * @param Modpack $modpack
     * @return ModPackResource|Response|\Inertia\Response|ResponseFactory
     */
    public function show(Request $request, Modpack $modpack)
    {
     return $this->edit($request, $modpack);
    }

  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @param Modpack $modpack
   * @return ModPackResource|Response|\Inertia\Response|ResponseFactory
   */
    public function edit(Request $request, Modpack $modpack): Response|ModPackResource|\Inertia\Response|ResponseFactory
    {
        if ($request->wantsJson()) {
            return ModPackResource::make($modpack);
        }

        $servers = Server::whereGameId($modpack->game_id)
          ->get()
          ->map(fn(Server $server) => $server->only(['id', 'name', 'logo_url', 'game']));

        $modpack->load('servers');

        return inertia('ModPacks/Edit', compact('servers', 'modpack'));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param EditModPackRequest $request
   * @param Modpack $modpack
   * @param EditModPack $editor
   * @return RedirectResponse|Response
   * @throws ModPackException
   */
    public function update(EditModPackRequest $request, Modpack $modpack, EditModPack $editor)
    {
      $editor->editModPack($modpack, $request->all());

      if ($request->wantsJson()) {
        return response()->noContent();
      }

      flash($request->get('name'), 'This ModPack has been successfully updated!')->success();
      return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Modpack $modpack
     * @return RedirectResponse|Response
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Request $request, Modpack $modpack)
    {
        if ($modpack->batch) {
            abort(Response::HTTP_LOCKED, 'Cannot delete while an update in progress...');
        }

        $modpack->delete();

        if ($request->wantsJson()) {
          return response()->noContent();
        }

        flash('ModPack Deleted',   '"'. $modpack->getAttribute('name') .'" has been successfully deleted!')->danger();
        return back();
    }

    public function showUpdate(Request $request, Modpack $modpack)
    {
      $modpack->servers;

      return inertia('ModPacks/Update', compact('modpack'));
    }

    /**
     * @param Modpack $modpack
     * @return Response
     */
    public function startUpdate(Modpack $modpack): Response
    {
        if ($modpack->batch) {
            abort(Response::HTTP_LOCKED, 'Update already in progress...');
        }

        ModPackUpdateRequested::broadcast($modpack);

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * @param Modpack $modpack
     * @return Response
     */
    public function cancelUpdate(Modpack $modpack): Response
    {
        if (!$modpack->batch) {
            abort(Response::HTTP_CONTINUE, 'Cannot cancel update, no update in progress...');
        }

        $modpack->batch->cancel();

        $modpack->update([
            'job_batch_id' => null,
        ]);

        return response()->noContent();
    }
}
