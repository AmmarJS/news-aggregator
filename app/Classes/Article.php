<?php 

namespace App\Classes;

abstract class Article {
    protected string $author;
    protected string $category;
    protected string $date;
    protected string $description;
    protected string|null $image;
    protected string $source;
    protected string $title;
    protected string $url;

    protected string $endpoint;
    protected string $apiKey;

    // add your new article implementations here
    private static array $sources = [
        GuardianArticle::class,
        NewsArticle::class,
        NYTArticle::class
    ];

    /**
     * Returns the article info
     * @return array
     */
    public function getInfo() : array {
        return [
            "author" => $this->author,
            "category" => $this->category,
            "date" => $this->date,
            "description" => $this->description,
            "image" => $this->image,
            "source" => $this->source,
            "title" => $this->title,
            "url" => $this->url
        ];
    }

    public static function getSources() : array {
        return static::$sources;
    }
}