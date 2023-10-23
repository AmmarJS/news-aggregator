<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    public function index(Request $request) {
        if(!Article::query()->exists()) Article::refreshArticles();

        // pagination
        $page_size = 10;
        if(isset($request->page_size) && !empty($request->page_size)) {
            if($request->page_size > 20) $page_size = 20;
            else if($request->page_size < 5) $page_size = 5;
            else $page_size = $request->page_size;
        }

        // ordering
        $order = "desc";
        if(isset($request->order) && !empty($request->order)) {
            if($request->order == "oldest") $order = "asc";
            if($request->order == "newest") $order = "desc";
        }
        
        // filtering
        $query = "";
        $date = "";
        $category = "";
        $source = "";
        $authors = "";

        // response
        return ArticleResource::collection(Article::orderBy('date', $order)->paginate($page_size));
    }
}
