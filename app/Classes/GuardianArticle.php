<?php

namespace App\Classes;

use App\Interfaces\IArticle;
use App\Classes\Article;
use App\Models\Article as ArticleModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GuardianArticle extends Article implements IArticle {

    public function __construct() {
        $this->endpoint = 'https://content.guardianapis.com/search';
        $this->apiKey = env('GUARDIAN_API_KEY');
    } 

    public function fetchArticles() : array {
        $guardianApiResponse = Http::get($this->endpoint, [
            'api-key' => $this->apiKey,
            'show-fields' => 'thumbnail',
            'page-size' => '20',
        ]);

        if($guardianApiResponse->ok()) return $guardianApiResponse->object()->response->results;

        return [];
    }

    public function saveArticles(array $articles) {
        foreach($articles as $article) {
            $this->author = $article->author ?? "No author";
            $this->category = $article->category ?? "General";
            $this->date = Carbon::parse($article->webPublicationDate)->setTimezone('UTC')->format('Y-m-d H:i:s');;
            $this->description = $article->description ?? "No description";
            $this->image = $article->fields->thumbnail ?? null;
            $this->source = "The Guardian";
            $this->title = $article->webTitle ?? "No title";
            $this->url = $article->webUrl;
            ArticleModel::create($this->getInfo());
        }
    }
}