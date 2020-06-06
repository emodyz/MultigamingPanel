<?php

namespace App\Http\Controllers;

use App\Modpack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModpackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $modpacks = Modpack::get();

        if ($request->wantsJson()) {
            return response()->json($modpacks);
        }

        return view('modpacks.index')->with(compact('modpacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:modpacks,name|max:30|string',
        ]);

        $cleanedName = preg_replace("/[^a-zA-Z0-9]+/", "", $request->get('name'));
        $modpackPath = "modpacks/$cleanedName";

        $modpack = Modpack::create(
            array_merge($request->only(['name']), ['path' => $modpackPath])
        );

        if ($request->wantsJson()) {
            return response()->json($modpack);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
