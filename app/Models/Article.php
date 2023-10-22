<?php

namespace App\Models;

use App\Classes\GuardianArticle;
use App\Classes\NewsArticle;
use App\Classes\NYTArticle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Article extends Model
{

    protected $guarded = [];

    use HasFactory;

    public static function refreshArticles() {

        $articles = array();

        $newsApiResponse = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => env('NEWS_API_KEY'),
            'country' => 'us',
        ]);
        if($newsApiResponse->ok()) {
            foreach($newsApiResponse->object()->articles as $article) {
                array_push($articles, (new NewsArticle($article))->getInfo());
            }
        }
        
        $guardianApiResponse = Http::get('https://content.guardianapis.com/search', [
            'api-key' => env('GUARDIAN_API_KEY'),
            'show-fields' => 'thumbnail',
            'page-size' => '20',
        ]);
        if($guardianApiResponse->ok()) {
            foreach($guardianApiResponse->object()->response->results as $article) {
                array_push($articles, (new GuardianArticle($article))->getInfo());
            }
        }

        $nytApiResponse = Http::get('https://api.nytimes.com/svc/mostpopular/v2/emailed/7.json', [
            'api-key' => env('NYT_API_KEY'),
        ]);
        if($nytApiResponse->ok()) {
            foreach($nytApiResponse->object()->results as $article) {
                array_push($articles, (new NYTArticle($article))->getInfo());
            }
        }

        self::createMany($articles);
    }
}
