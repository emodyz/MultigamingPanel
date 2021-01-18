<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\Articles\CreateArticle;
use App\Actions\Emodyz\Articles\EditArticle;
use App\Http\Requests\Articles\CreateArticleRequest;
use App\Http\Requests\Articles\EditArticleRequest;
use App\Models\Article;
use App\Models\Server;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function __construct()
    {

        $this->middleware('can:articles-index', ['only' => ['index']]);

        $this->middleware('can:articles-create', ['only' => ['create', 'store']]);

        $this->middleware('can:articles-edit', ['only' => ['edit', 'update']]);

        $this->middleware('can:articles-destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {

        $orderBy = $request->query('orderBy');

        $initialSearch = $request->query('search', '');

        $articlesQuery = Article::query()
            ->select('id', 'title', 'subTitle', 'slug', 'status', 'cover_image_path', 'user_id', 'created_at', 'published_at', 'created_at')
            ->when($request->filled('search'), function ($query) use ($initialSearch) {
                $query->where('title', 'LIKE', '%' . $initialSearch . '%')
                    ->orWhere('slug', 'LIKE', '%' . $initialSearch . '%');
            })
            ->when($request->filled('orderBy'), function ($query) use ($orderBy) {
                $orderByKey = $orderBy['key'];
                $orderByDirection = $orderBy['direction'];
                $query->orderBy($orderByKey === 'author.name' ? 'user_id' : $orderByKey, $orderByDirection);
            });

        $articles = $articlesQuery
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->only(['search']));

        $totalItemCount = $articles->total();

        return Inertia::render('Articles/Index', compact('articles', 'initialSearch', 'totalItemCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        $servers = Server::all()->map(fn(Server $server) => $server->only(['id', 'name', 'logo_url', 'game']));

        return Inertia::render('Articles/Create', compact('servers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateArticleRequest $request
     * @param CreateArticle $store
     * @return RedirectResponse
     */
    public function store(CreateArticleRequest $request, CreateArticle $store): RedirectResponse
    {
        $store->storeNewArticle($request->all());

        $request->get('status') === 'draft'
            ? flash('Draft', 'Your new draft has ben saved!')->success()
            : flash($request->get('title'), 'Your new article has ben published!')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return \Inertia\Response
     */
    public function edit(Article $article): \Inertia\Response
    {
        $servers = Server::all()->map(fn(Server $server) => $server->only(['id', 'name', 'logo_url', 'game']));

        $article->servers;

        return Inertia::render('Articles/Edit', compact('servers', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditArticleRequest $request
     * @param Article $article
     * @param EditArticle $editor
     * @return RedirectResponse
     */
    public function update(EditArticleRequest $request, Article $article, EditArticle $editor): RedirectResponse
    {
        $editor->editArticle($article, $request->all());

        flash($request->get('title'),   'This article has been successfully updated!')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        flash('Article Deleted',   '"'. $article->getAttribute('title') .'" has been successfully deleted!')->danger();
        return back(303);
    }
}
