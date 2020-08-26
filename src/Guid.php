<?php
namespace Bobel\Helpers;

/**
 * Guid helpers
 *
 * @author Dmitrii Litovchenko
 */
class Guid
{
    /**
     * Generates GUID
     *
     * @return string
     */
    public static function generate(): string
    {
        if (function_exists('com_create_guid') === true)
        {
            $result = trim(com_create_guid(), '{}');
        } else {
            $result = sprintf(
                '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
                mt_rand(0, 65535),
                mt_rand(0, 65535),
                mt_rand(0, 65535),
                mt_rand(16384, 20479),
                mt_rand(32768, 49151),
                mt_rand(0, 65535),
                mt_rand(0, 65535),
                mt_rand(0, 65535));
        }

        return $result;
    }
}
