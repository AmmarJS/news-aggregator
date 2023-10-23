<?php

namespace App\Enums;

use Carbon\Carbon;

enum DateFilters : string {
    case LAST_HOUR = "last_hour";
    case LAST_DAY = "last_day";
    case LAST_WEEK = "last_week";
    case LAST_MONTH = "last_month";
    case LAST_YEAR = "last_year";

    public function getStartDate() {
        $startDate = Carbon::now();
        switch ($this) {
            case self::LAST_HOUR:
                $startDate = $startDate->subHour();
                break;
            case self::LAST_DAY:
                $startDate = $startDate->subDay();
                break;
            case self::LAST_WEEK:
                $startDate = $startDate->subWeek();
                break;
            case self::LAST_MONTH:
                $startDate = $startDate->subMonth();
                break;
            case self::LAST_YEAR:
                $startDate = $startDate->subYear();
                break;
            default:
                $startDate = $startDate->subYears(2);
        }

        return $startDate;
    }
}