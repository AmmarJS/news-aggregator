<?php

namespace App\Classes;

use App\Interfaces\IArticle;
use App\Classes\Article;
use App\Models\Article as ArticleModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NYTArticle extends Article implements IArticle {

    public function __construct() {
        $this->endpoint = 'https://api.nytimes.com/svc/mostpopular/v2/emailed/7.json';
        $this->apiKey = env('NYT_API_KEY');
    } 

    public function fetchArticles() : array {
        $nytApiResponse = Http::get($this->endpoint, [
            'api-key' => $this->apiKey,
        ]);

        if($nytApiResponse->ok()) return $nytApiResponse->object()->results;
        
        return [];
    }

    public function saveArticles(array $articles) {
        foreach($articles as $article) {
            $this->author = substr($article->byline, 3) ?? "No author";
            $this->category = $article->section ?? "General";
            $this->date = Carbon::parse($article->published_date)->setTimezone('UTC')->format('Y-m-d H:i:s');;
            $this->description = $article->description ?? "No description";
            $this->image = $article->fields->thumbnail ?? null;
            $this->source = $article->source ?? "New York Times";
            $this->title = $article->title ?? "No title";
            $this->url = $article->url;
            ArticleModel::create($this->getInfo());
        }
    }
}