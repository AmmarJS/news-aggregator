<?php

namespace App\Interfaces;

interface IArticle {
    /**
     * fetches articles from the datasource
     * 
     * @return array
     */
    public function fetchArticles() : array;
    /**
     * saves articles to the database
     * 
     * @param array $articles articles to save to the database
     */
    public function saveArticles(array $articles);
}