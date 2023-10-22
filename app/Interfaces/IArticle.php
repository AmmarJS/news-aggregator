<?php

namespace App\Interfaces;

interface IArticle {
    /**
     * Returns article info
     */
    public function getInfo() : array;
}