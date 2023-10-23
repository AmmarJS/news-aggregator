<?php

namespace App\Traits;

trait PaginatorHelpers {

    /**
     * @param string url with query parameters
     * @param string url without query parameters
     * 
     * returns the url without page query parameter
     */
    public function getUrlWithoutPage(string $withQueryParams, string $withoutQueryParams) : string {
        $params = [];
        $query = parse_url($withQueryParams, PHP_URL_QUERY);
        parse_str($query, $params);
        unset($params['page']);
        return $withoutQueryParams . "?" . http_build_query($params);
    }
}