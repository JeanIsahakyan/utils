<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Time {
    public const SECOND = 1;
    public const MINUTE = 60;
    public const HOUR   = 3600;
    public const DAY    = 86400;
    public const WEEK   = 604800;
    public const MONTH  = 2628000;
    public const YEAR   = 31536000;

    /**
     * @param int $timestamp
     *
     * @return int
     */
    public static function getDayTime($timestamp): int {
        [$day, $month, $year] = self::getDMY($timestamp);
        return mktime(0, 0, 0, $month, $day, $year);
    }

    /**
     * @param int $timestamp
     *
     * @return int[]
     */
    public static function getDMY($timestamp): array {
       return explode(',', date('d,m,Y', $timestamp));
    }

    public static function getTime(): int {
        return time();
    }

}
