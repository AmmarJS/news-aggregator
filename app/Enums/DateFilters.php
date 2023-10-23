<?php

namespace App\Enums;

enum DateFilters : string {
    case LAST_HOUR = "last_hour";
    case LAST_DAY = "last_day";
    case LAST_WEEK = "last_week";
    case LAST_MONTH = "last_month";
    case LAST_YEAR = "last_year";
}