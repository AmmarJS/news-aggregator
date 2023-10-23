<?php

namespace App\Enums;

enum OrderingCases : string {
    case NEWEST = "newest";
    case OLDEST = "oldest";

    public function getOrdering() {
        switch($this) {
            case self::NEWEST:
                return 'desc';
            case self::OLDEST:
                return 'asc';
            default:
                return 'desc';
        }
    }
}