<?php

namespace App\Models;

use App\Classes\Article as ArticleBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $guarded = [];

    use HasFactory;

    public static function refreshArticles() {
        
        self::query()->truncate();

        foreach(ArticleBase::getSources() as $class) {
            if(class_exists($class)) {
                $source = new $class();
                $classArticles = $source->fetchArticles();
                $source->saveArticles($classArticles);
            }
                
        }
    }
}
