<?php

namespace App\Classes;

use App\Classes\Article;
use Carbon\Carbon;

class NewsArticle extends Article {

    /**
     * @param object $article
     */
    public function __construct(object $article) {
        $this->author = $article->author ?? "No author";
        $this->category = $article->category ?? "General";
        $this->date = Carbon::parse($article->publishedAt)->setTimezone('UTC')->format('Y-m-d H:i:s');;
        $this->description = $article->description ?? "No description";
        $this->image = $article->urlToImage ?? null;
        $this->source = $article->source->name ?? "No source";
        $this->title = $article->title ?? "No title";
        $this->url = $article->url;
    }
}