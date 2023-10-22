<?php

namespace App\Classes;

use App\Classes\Article;
use Carbon\Carbon;

class NYTArticle extends Article {

    /**
     * @param object $article
     */
    public function __construct(object $article) {
        $this->author = substr($article->byline, 3) ?? "No author";
        $this->category = $article->section ?? "General";
        $this->date = Carbon::parse($article->published_date)->setTimezone('UTC')->format('Y-m-d H:i:s');;
        $this->description = $article->description ?? "No description";
        // TODO: determine how to get the thumbnail
        $this->image = $article->fields->thumbnail ?? null;
        $this->source = $article->source ?? "New York Times";
        $this->title = $article->title ?? "No title";
        $this->url = $article->url;
    }
}