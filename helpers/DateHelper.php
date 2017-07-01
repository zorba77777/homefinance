<?php
namespace app\helpers;

class DateHelper
{
    public static function get_monday($week, $year = "")
    {
        $first_date = strtotime("1 january " . ($year ? $year : date("Y")));
        if (date("D", $first_date) == "Mon") {
            $monday = $first_date;
        } else {
            $monday = strtotime("next Monday", $first_date) - 604800;
        }
        $plus_week = "+" . $week . " week";
        return strtotime($plus_week, $monday);
    }

    public static function get_sunday($week, $year = "")
    {
        return self::get_monday($week, $year) + 604799;
    }
}