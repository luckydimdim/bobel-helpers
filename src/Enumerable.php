<?php
namespace Bobel\Helpers;

/**
 * Arrays helpers
 *
 * @author Dmitrii Litovchenko
 */
class Enumerable
{
    /**
     * Clear array empty elements
     *
     * @param array $array Array
     * @return array
     */
    public static function clear(array $array): array
    {
        foreach ($array as $key => $item) {
            if ($item == '') {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Create multidimensional array unique for any single key index
     *
     * @param $array
     * @param $key
     * @return array
     */
    public static function uniqueMulti(array $array, string $key): array
    {
        $temp_array = [];
        $i = 0;
        $key_array = [];

        foreach ($array as $val) {
            if ( !in_array($val[$key], $key_array) ) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }

            $i++;
        }

        return $temp_array;
    }

    /**
     * Access an array index, retrieving the value stored there if it
     * exists or a default if it does not. This function allows you to
     * concisely access an index which may or may not exist without
     * raising a warning.
     *
     * @param array $var Array value to access
     * @param mixed $default Default value to return if the key is not
     *                         present in the array
     * @return mixed
     */
    public static function get(&$var, $default = null)
    {
        if ( isset($var) ) {
            return $var;
        }

        return $default;
    }

    /**
     * Accepts an array, and returns an array of values from that array as
     * specified by $field. For example, if the array is full of objects
     * and you call util::array_pluck($array, 'name'), the function will
     * return an array of values from $array[]->name.
     *
     * @param array $array An array
     * @param string $field The field to get values from
     * @param boolean $preserve_keys Whether or not to preserve the
     *                                   array keys
     * @param boolean $remove_nomatches If the field doesn't appear to be set,
     *                                   remove it from the array
     * @return array
     */
    public static function pluck(array $array, string $field, bool $preserve_keys = true, bool $remove_nomatches = true): array
    {
        $new_list = array();

        foreach ($array as $key => $value) {
            if (is_object($value)) {
                if (isset($value->{$field})) {
                    if ($preserve_keys) {
                        $new_list[$key] = $value->{$field};
                    } else {
                        $new_list[] = $value->{$field};
                    }
                } elseif (!$remove_nomatches) {
                    $new_list[$key] = $value;
                }
            } else {
                if (isset($value[$field])) {
                    if ($preserve_keys) {
                        $new_list[$key] = $value[$field];
                    } else {
                        $new_list[] = $value[$field];
                    }
                } elseif (!$remove_nomatches) {
                    $new_list[$key] = $value;
                }
            }
        }

        return $new_list;
    }

    /**
     * Converts nested objects to associative array
     *
     * @param mixed $obj
     * @return array
     */
    public static function objectToArray($obj)
    {
        return json_decode(json_encode($obj), true);
    }
}
