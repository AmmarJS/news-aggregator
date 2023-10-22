<?php 

namespace App\Classes;

use App\Interfaces\IArticle;
use DateTime;

abstract class Article implements IArticle {
    protected string $author;
    protected string $category;
    protected string $date;
    protected string $description;
    protected string|null $image;
    protected string $source;
    protected string $title;
    protected string $url;

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
}