<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Traits\Response;
use App\Traits\PaginatorHelpers;
use App\Enums\OrderingCases;
use App\Enums\DateFilters;

class ArticleController extends Controller
{

    use Response, PaginatorHelpers;

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
            if($request->order == OrderingCases::OLDEST->value) $order = "asc";
            if($request->order == OrderingCases::NEWEST->value) $order = "desc";
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
                case DateFilters::LAST_HOUR->value:
                    $startDate = $startDate->subHour();
                    break;
                case DateFilters::LAST_DAY->value:
                    $startDate = $startDate->subDay();
                    break;
                case DateFilters::LAST_WEEK->value:
                    $startDate = $startDate->subWeek();
                    break;
                case DateFilters::LAST_MONTH->value:
                    $startDate = $startDate->subMonth();
                    break;
                case DateFilters::LAST_YEAR->value:
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
        $results = $articles->orderBy('date', $order);
        $count = $results->count();
        
        $paginator = new LengthAwarePaginator(ArticleResource::collection($results->paginate($page_size)), $count,$page_size, $page,[
            "path" => $this->getUrlWithoutPage($request->fullUrl(), $request->url())
        ]);
        
        return $this->response([
            "authors" => $distinct_authors,
            "categories" => $distinct_categories,
            "articles" => $paginator,
            "sources" => $distinct_sources
        ]);
    }
}
