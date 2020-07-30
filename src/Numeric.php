<?php
namespace Bobel\Helpers;

/**
 * Numeric helpers
 *
 * @author Dmitrii Litovchenko
 */
class Numeric
{
    static function getDeclension(int $number, array $endingArray): string
    {
        $number = $number % 100;

        if ($number >= 11 && $number <= 19) {
            $ending = $endingArray[2];
        } else {
            $i = $number % 10;
            switch ($i) {
                case (1):
                    $ending = $endingArray[0];
                    break;
                case (2):
                case (3):
                case (4):
                    $ending = $endingArray[1];
                    break;
                default:
                    $ending = $endingArray[2];
            }
        }

        return $ending;
    }

    /**
     * Formats number to price
     *
     * @param $price float
     * @param int $decimals
     * @return string
     */
    public static function formatPrice($price, int $decimals = 2): string
    {
        $price = $price ? $price : 0;

        $result = number_format($price, $decimals, '.', ' ');

        return $result;
    }

    /**
     * Round up with certain accuracy
     *
     * @param $number
     * @param $nearest
     * @return float
     */
    public static function roundUp($number, $nearest = 0.5)
    {
        if ($number == 0) {
            return 0;
        }

        $int_num = intval($number);
        $fraction_num = $number - $int_num;

        if ($fraction_num > $nearest) {
            $fraction_num = 1;
        } else {
            $fraction_num = $nearest;
        }

        return $int_num + $fraction_num;
    }
}
