<?php

namespace App\Http\Controllers;

use App\Http\Requests\Articles\CreateArticleRequest;
use App\Models\Article;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ArticleController extends Controller
{
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
            ->select('id', 'title', 'subTitle', 'slug', 'status', 'cover_image_path', 'user_id','created_at', 'published_at', 'created_at')
            ->when($request->filled('search'),function($query) use ($initialSearch){
                $query->where('title','LIKE','%'.$initialSearch.'%')
                    ->orWhere('slug','LIKE','%'.$initialSearch.'%');
            })
            ->when($request->filled('orderBy'),function($query) use ($orderBy){
                $query->orderBy($orderBy['key'], $orderBy['direction']);
            });

        $articles = $articlesQuery
            ->paginate(10)
            ->onEachSide(2)
            ->appends(request()->only(['search']));

        $totalItemCount = $articles->total();

        return Inertia::render('Articles/Index',compact('articles', 'initialSearch', 'totalItemCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        $servers = Server::all()->map(function ($server) {
            return collect($server)->only(['id', 'name', 'logo_url', 'game']);
        });
        return Inertia::render('Articles/Create', compact('servers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateArticleRequest $request
     * @return RedirectResponse
     */
    public function store(CreateArticleRequest $request): RedirectResponse
    {
        $article = new Article();

        $title = $request->get('title');
        $servers = $request->get('servers');

        $article->setAttribute('title', $title);
        $article->setAttribute('subTitle', $request->get('subTitle'));
        $article->setAttribute('slug', Str::slug($title));
        $article->setAttribute('content', $request->get('content'));

        $article->setAttribute('user_id', $request->user()->id);

        $article->setInitialCoverImage($request->file('coverImage'));

        if ($request->get('status') === 'published') {
            $article->setAttribute('status', 'published');
            $article->setAttribute('published_at', now());
        }

        $article->save();

        if ($servers) {
            foreach ($servers as $server) {
                $article->servers()->attach($server);
            }
        }

        return back()->with('status', 'article-created');
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
     * @return Response
     */
    public function edit(Article $article): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function update(Request $request, Article $article): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return Response
     */
    public function destroy(Article $article): Response
    {
        //
    }
}
