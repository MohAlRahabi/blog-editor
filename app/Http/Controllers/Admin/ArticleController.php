<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateArticleRequest;
use App\Models\Article;
use App\Traits\FileHandler;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller {

    use FileHandler;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * return articles view
     * @return Application|Factory|View|JsonResponse
     */
    public function index()
    {
        return view('dashboard.articles.index');
    }

    /**
     * return articles view
     * @return Application|Factory|View|JsonResponse
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('dashboard.articles.show',compact(['article']));
    }

    /**
     * return view to create article
     * @return Application|Factory|View|JsonResponse
     */
    public function create()
    {
        return view('dashboard.articles.create');
    }

    /**
     * return view to edit article
     * @param $id
     * @return Application|Factory|View|JsonResponse
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('dashboard.articles.edit',compact(['article']));
    }

    /**
     * return data of all articles
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function data(Request $request)
    {
        $auth_user = auth()->user();
        if($auth_user->hasRole(UserRoleEnum::ADMIN))
            $items = Article::query()->select('articles.*');
        else
            $items = Article::query()->where('author_id',$auth_user->id)->select('articles.*');
        return DataTables::eloquent($items)
            ->addColumn('action', function ($item) {
                return '<a class="edit btn btn-xs btn-dark" href="'.route("articles.show",$item->id).'" style="color:#fff"><i class="fas fa-eye"></i> View</a>
                        <a class="delete btn btn-xs btn-danger" style="color:#fff"><i class="fas fa-trash"></i> Delete</a>';
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in database.
     * @param StoreUpdateArticleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUpdateArticleRequest $request)
    {
        $article = Article::create($request->only([
            'title',
            'content',
            'author_id',
        ]));
        return redirect()->route('articles.index')->with('success','Added Successfully');
    }

    /**
     * Update the specified resource in database.
     * @param  StoreUpdateArticleRequest $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(StoreUpdateArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->only([
            'title',
            'content',
        ]));
        return redirect()->route('articles.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from database.
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $blog = Article::findOrFail($id);
        $blog->delete();
        return response()->json(['status'=>200,'message' => 'Successfully Deleted!'],200);
    }
}
