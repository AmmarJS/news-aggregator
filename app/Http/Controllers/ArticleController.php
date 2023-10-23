<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Pagination\Paginator;

class ArticleController extends Controller
{
    public function index(Request $request) {
        if(!Article::query()->exists()) Article::refreshArticles();

        // pagination
        $page_size = 10;
        $page = $request->page;
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
        $articles = Article::query();

        if(isset($request->q) && !empty($request->q)) {
            $query = $request->q;
            $articles->where("title", "LIKE", "%$query%")->orWhere("description", "LIKE", "%$query%");
        }

        if(isset($request->category) && !empty($request->category)) {
            $category = $request->category;
            $articles->where("category", $category);
        }

        if(isset($request->source) && !empty($request->source)) {
            $source = $request->source;
            $articles->where("source", $source);
        }

        if(isset($request->author) && !empty($request->author)) {
            $author = $request->author;
            $articles->where("author", $author);
        }

        if(isset($request->date) && !empty($request->date)) {
            $date = $request->date;
            $startDate = Carbon::now();
            switch ($date) {
                case 'last hour':
                    $startDate = $startDate->subHour();
                    break;
                case 'last day':
                    $startDate = $startDate->subDay();
                    break;
                case 'last week':
                    $startDate = $startDate->subWeek();
                    break;
                case 'last month':
                    $startDate = $startDate->subMonth();
                    break;
                case 'last year':
                    $startDate = $startDate->subYear();
                    break;
                default:
                    $startDate = $startDate->subYears(2);
            }

            $articles->where('date', '>=', $startDate);
        }

        // response
        $distinct_articles = Article::distinct();
        $distinct_authors = $distinct_articles->pluck("author");
        $distinct_categories = $distinct_articles->pluck("category");
        $distinct_sources = $distinct_articles->pluck("source");
        $results = $articles->orderBy('date', $order)->get();
        return [
            "authors" => $distinct_authors,
            "categories" => $distinct_categories,
            "results" => new Paginator(ArticleResource::collection($results), $page_size, $page),
            "sources" => $distinct_sources
        ];
    }
}
