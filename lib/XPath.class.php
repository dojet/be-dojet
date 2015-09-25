<?php
/**
 * xpath
 *
 * Filename: XPath.class.php
 *
 * @author setimouse@gmail.com
 * @since 2014 5 4
 */
class XPath {

    public static function path($xpath, $array) {
        $key = strtok($xpath, '.');

        while (false !== $key && $array) {
            if (!key_exists($key, (array)$array)) {
                return null;
            }
            $array = $array[$key];
            $key = strtok('.');
        }
        return $array;
    }

}
