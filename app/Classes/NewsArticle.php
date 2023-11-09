<?php

namespace App\Classes;

use App\Interfaces\IArticle;
use App\Classes\Article;
use App\Models\Article as ArticleModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsArticle extends Article implements IArticle {

    public function __construct() {
        $this->endpoint = 'https://newsapi.org/v2/top-headlines';
        $this->apiKey = env('NEWS_API_KEY');
    } 

    public function fetchArticles() : array {
        $newsApiResponse = Http::get($this->endpoint, [
            'apiKey' => $this->apiKey,
            'country' => 'us',
        ]);

        if($newsApiResponse->ok()) return $newsApiResponse->object()->articles;

        return [];
    }

    public function saveArticles(array $articles) {
        foreach($articles as $article) {
            $this->author = $article->author ?? "No author";
            $this->category = $article->category ?? "General";
            $this->date = Carbon::parse($article->publishedAt)->setTimezone('UTC')->format('Y-m-d H:i:s');
            $this->description = $article->description ?? "No description";
            $this->image = $article->urlToImage ?? null;
            $this->source = $article->source->name ?? "No source";
            $this->title = $article->title ?? "No title";
            $this->url = $article->url;
            ArticleModel::create($this->getInfo());
        }
    }
}