<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function home() {
        $articles = Article::all();
        return view('frontend.home.index',compact(['articles']));
    }

    public function singleBlog($slug) {
        $article = Article::whereSlug($slug)->first();
        if($article)
            return view('frontend.blogs.single',compact(['article']));
        abort(404);
    }
}
