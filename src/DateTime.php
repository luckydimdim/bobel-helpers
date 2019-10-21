<?php
namespace Bobel\Helpers;

/**
 * Helpful datetime functions
 *
 * @author Dmitrii Litovchenko
 */
class DateTime
{
    /**
     * Formats date to yyyy-mm-dd HH:ii:ss
     *
     * @param $dateTime
     * @return string
     * @throws \Exception
     */
    public static function toSql($dateTime)
    {
        $result = null;

        if (!$dateTime) {
            return $result;
        }

        $format = 'Y-m-d H:i:s';

        $result = ( new \DateTime($dateTime) )->format($format);

        return $result;
    }

    /**
     * Validate format
     *
     * @param $date
     * @param string $format
     * @return bool
     */
    public static function isValid($date, $format = 'd.m.Y')
    {
        $d = \DateTime::createFromFormat($format, $date);
        $result = $d && $d->format($format) === $date;

        return $result;
    }

    /**
     * Gets first day of next month
     *
     * @param string $format
     * @return string
     */
    public static function getFirstDayOfNextMonth(string $format = 'd-F-Y') : string
    {
        $result = date($format, strtotime('first day of +1 month'));

        return $result;
    }
}
