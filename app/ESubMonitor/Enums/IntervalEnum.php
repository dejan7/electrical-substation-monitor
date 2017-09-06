<?php

namespace App\ESubMonitor\Enums;

class IntervalEnum
{
    const REAL_TIME = "real-time";
    const _1M = "1m";
    const _5M = "5m";
    const _60M = "60m";
    const _6H = "6h";
    const _24h = "24h";

    public static function get($text)
    {
        switch ($text):
            case self::REAL_TIME:
                return self::REAL_TIME;
            case self::_1M:
                return self::_1M;
            case self::_5M:
                return self::_5M;
            case self::_60M:
                return self::_60M;
            case self::_6H:
                return self::_6H;
            case self::_24h:
                return self::_24h;
            default:
                throw new \Exception("Unsupported Interval!");
        endswitch;
    }
}