<?php

namespace Medboubazine\LaravelHelpers\Classes\Number;

final class Number
{
    /**
     * get
     *
     * @param  int $decimals
     * @return string
     */
    public static function format(string $number, int $decimals = 2): string
    {
        return self::number_format($number, $decimals);
    }
    /**
     * get
     *
     * @param  int $decimals
     * @return string
     */
    public static function pretty(string $number, int $decimals = 2): string
    {
        return self::number_format($number, $decimals, ".", " ");
    }
    /**
     * number_format
     *
     * @param  float $number
     * @param  int $decimals
     * @param  string $dec_point
     * @param  string $thousands_sep
     * @return string
     */
    protected static function number_format($number, int $decimals = 0, string $dec_point = ".", string $thousands_sep = ""): string
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
}
