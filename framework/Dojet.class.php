<?php
/**
 * @author     Leeyan <setimouse@gmail.com>
 * @copyright  2009-2016 Leeyan.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    0.1
 */
class Dojet {

    private static $modules = array();

    public function start(Service $service) {
        $service->dojetDidStart();
    }

    public static function addModule($module) {
        require_once $module.'/init.php';
    }

}
