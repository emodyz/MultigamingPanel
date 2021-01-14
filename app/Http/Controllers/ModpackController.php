<?php

namespace App\Http\Controllers;

use App\Events\Modpack\ModpackUpdateRequested;
use App\Exceptions\ModpackException;
use App\Http\Requests\Modpacks\CreateModpackRequest;
use App\Http\Resources\Modpack\ModpackResource;
use App\Models\Modpack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\ResponseFactory;

class ModpackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection|Response|\Inertia\Response|ResponseFactory
     */
    public function index(Request $request): Response|AnonymousResourceCollection|\Inertia\Response|ResponseFactory
    {
        $modpacks = Modpack::with('servers')
            ->latest()
            ->get();

        if ($request->wantsJson()) {
            return ModpackResource::collection($modpacks);
        }

        return inertia('Modpacks/Index', [
            'modpacks' => $modpacks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateModpackRequest $request
     * @return ModpackResource
     * @throws ModpackException
     */
    public function store(CreateModpackRequest $request): ModpackResource
    {
        $name = $request->get('name');
        $path = $request->get('path') ?? Str::ascii($name);
        $disk = $request->get('disk') ?? 'modpacks';

        if (!Arr::exists(config('filesystems.disks'), $disk)) {
            throw ModpackException::invalidDisk($disk);
        }

        $modpack = Modpack::create([
            'name' => $name,
            'path' => $path,
            'disk' => $disk,
        ]);

        return ModpackResource::make($modpack);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Modpack $modpack
     * @return ModpackResource|Response|\Inertia\Response|ResponseFactory
     */
    public function show(Request $request, Modpack $modpack): Response|ModpackResource|\Inertia\Response|ResponseFactory
    {
        if ($request->wantsJson()) {
            return ModpackResource::make($modpack);
        }

        return inertia('Modpacks/Show', [
            'modpack' => $modpack
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Modpack $modpack
     * @return Response
     */
    public function update(Request $request, Modpack $modpack): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Modpack $modpack
     * @return Response
     * @throws Exception
     */
    public function destroy(Modpack $modpack): Response
    {
        if ($modpack->batch) {
            abort(Response::HTTP_LOCKED, 'Cannot delete while an update in progress...');
        }

        $modpack->delete();
        return response()->noContent();
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

        ModpackUpdateRequested::broadcast($modpack);

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
        return response()->noContent();
    }
}
