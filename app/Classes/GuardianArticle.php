<?php

namespace App\Classes;

use App\Classes\Article;
use Carbon\Carbon;

class GuardianArticle extends Article {

    /**
     * @param object $article
     */
    public function __construct(object $article) {
        $this->author = $article->author ?? "No author";
        $this->category = $article->category ?? "General";
        $this->date = Carbon::parse($article->webPublicationDate)->setTimezone('UTC')->format('Y-m-d H:i:s');;
        $this->description = $article->description ?? "No description";
        $this->image = $article->fields->thumbnail ?? null;
        $this->source = "The Guardian";
        $this->title = $article->webTitle ?? "No title";
        $this->url = $article->webUrl;
    }
}