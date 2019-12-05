<?php
namespace Bobel\Helpers;

/**
 * String helper
 *
 * @author Dmitrii Litovchenko
 */
class Text
{
    /**
     * Generates a string of random characters.
     *
     * @param   integer $length             The length of the string to
     *                                      generate
     * @param   boolean $humanFriendly     Whether or not to make the
     *                                      string human friendly by
     *                                      removing characters that can be
     *                                      confused with other characters (
     *                                      O and 0, l and 1, etc)
     * @param   boolean $includeSymbols    Whether or not to include
     *                                      symbols in the string. Can not
     *                                      be enabled if $human_friendly is
     *                                      true
     * @param   boolean $noDuplicateChars Whether or not to only use
     *                                      characters once in the string.
     * @return  string
     *@throws  LengthException  If $length is bigger than the available
     *                           character pool and $no_duplicate_chars is
     *                           enabled
     *
     */
    public static function getRandomString(
        int $length = 16,
        bool $humanFriendly = true,
        bool $includeSymbols = false,
        bool $noDuplicateChars = false
    ): string {
        $nice_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefhjkmnprstuvwxyz23456789';
        $all_an     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $symbols    = '!@#$%^&*()~_-=+{}[]|:;<>,.?/"\'\\`';
        $string     = '';

        // Determine the pool of available characters based on the given parameters
        if ($humanFriendly) {
            $pool = $nice_chars;
        } else {
            $pool = $all_an;

            if ($includeSymbols) {
                $pool .= $symbols;
            }
        }

        if (!$noDuplicateChars) {
            return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
        }

        // Don't allow duplicate letters to be disabled if the length is
        // longer than the available characters
        if ($noDuplicateChars && strlen($pool) < $length) {
            throw new \LengthException('$length exceeds the size of the pool and $no_duplicate_chars is enabled');
        }

        // Convert the pool of characters into an array of characters and
        // shuffle the array
        $pool       = str_split($pool);
        $poolLength = count($pool);
        $rand       = mt_rand(0, $poolLength - 1);

        // Generate our string
        for ($i = 0; $i < $length; $i++) {
            $string .= $pool[$rand];
            // Remove the character from the array to avoid duplicates
            array_splice($pool, $rand, 1);
            // Generate a new number
            if (($poolLength - 2 - $i) > 0) {
                $rand = mt_rand(0, $poolLength - 2 - $i);
            } else {
                $rand = 0;
            }
        }

        return $string;
    }

    /**
     * Creates random number
     *
     * @param int $length
     * @return string
     */
    public static function getRandomNumber(int $length = 10): string
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    /**
     * Cleans phone number
     *
     * @param $value
     * @return bool|string
     */
    public static function sanitizePhoneNumber(string $value): string
    {
        $result = false;

        if (!$value) {
            return $result;
        }

        $result = preg_replace( '/\D/', '', $value);

        return $result;
    }

    /**
     * Strip all whitespaces from the given string.
     *
     * @param  string $string The string to strip
     * @return string
     */
    public static function stripSpaces(string $string): string
    {
        return preg_replace('/\s+/', '', $string);
    }

    /**
     * Serialize data, if needed.
     *
     * @param  mixed $data Data that might need to be serialized
     * @return mixed
     */
    public static function maybeSerialize($data): string
    {
        if ( is_array($data) || is_object($data) ) {
            return serialize($data);
        }

        return $data;
    }

    /**
     * Unserialize value only if it is serialized.
     *
     * @param  string $data A variable that may or may not be serialized
     * @return mixed
     */
    public static function maybeUnserialize(string $data)
    {
        // If it isn't a string, it isn't serialized
        if ( !is_string($data) ) {
            return $data;
        }

        $data = trim($data);

        // Is it the serialized NULL value?
        if ($data === 'N;') {
            return null;
        }

        $length = strlen($data);

        // Check some basic requirements of all serialized strings
        if ($length < 4 || $data[1] !== ':' || ($data[$length - 1] !== ';' && $data[$length - 1] !== '}')) {
            return $data;
        }

        // $data is the serialized false value
        if ($data === 'b:0;') {
            return false;
        }

        // Don't attempt to unserialize data that isn't serialized
        $uns = @unserialize($data);

        // Data failed to unserialize?
        if ($uns === false) {
            $uns = @unserialize( self::fixBrokenSerialization($data) );
            if ($uns === false) {
                return $data;
            } else {
                return $uns;
            }
        } else {
            return $uns;
        }
    }

    /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @param  mixed $data Value to check to see if was serialized
     * @return boolean
     */
    public static function isSerialized($data): bool
    {
        // If it isn't a string, it isn't serialized
        if ( !is_string($data) ) {
            return false;
        }

        $data = trim($data);

        // Is it the serialized NULL value?
        if ($data === 'N;') {
            return true;
        } elseif ($data === 'b:0;' || $data === 'b:1;') {

            // Is it a serialized boolean?
            return true;
        }

        $length = strlen($data);

        // Check some basic requirements of all serialized strings
        if ($length < 4 || $data[1] !== ':' || ($data[$length - 1] !== ';' && $data[$length - 1] !== '}')) {
            return false;
        }

        return @unserialize($data) !== false;
    }

    /**
     * Unserializes partially-corrupted arrays that occur sometimes. Addresses
     * specifically the `unserialize(): Error at offset xxx of yyy bytes` error.
     *
     * NOTE: This error can *frequently* occur with mismatched character sets
     * and higher-than-ASCII characters.
     *
     * Contributed by Theodore R. Smith of PHP Experts, Inc. <http://www.phpexperts.pro/>
     *
     * @param  string $brokenSerializedData
     * @return string
     */
    public static function fixBrokenSerialization(string $brokenSerializedData): string
    {
        $fixdSerializedData = preg_replace_callback('!s:(\d+):"(.*?)";!', function ($matches) {
            $snip = $matches[2];
            return 's:' . strlen($snip) . ':"' . $snip . '";';
        }, $brokenSerializedData);

        return $fixdSerializedData;
    }

    /**
     * Transliterates given string
     *
     * @param string $value
     * @return string
     */
    public static function transliterate(string $value): string
    {
        $transliterator = \Transliterator::create('Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove;');

        $result = $transliterator->transliterate($value);

        return $result;
    }
}
