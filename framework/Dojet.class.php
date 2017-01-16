<?php
/**
 * @author     Leeyan <setimouse@gmail.com>
 * @copyright  2009-2016 Leeyan.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    0.1
 */
class Dojet {

    private static $modules = array();
    private static $v = array();

    public static function v($key, $value = null) {
        if (is_null($value)) {
            return isset(self::$v[$key]) ? self::$v[$key] : '';
        }
        self::$v[$key] = $value;
    }

    public function start(Service $service) {
        $service->dojetDidStart();
    }

    public static function addModule($module) {
        $modpath = realpath($module);
        $modkey = md5($modpath);
        if (isset(self::$modules[$modkey])) {
            return;
        }
        self::$modules[$modkey] = $modpath;
        require_once $modpath.'/init.php';
    }

}
