<?php
/**
 * @author     Leeyan <setimouse@gmail.com>
 * @copyright  2009-2015 Leeyan.
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

    public static function initModule($moduleBundle) {

        if (array_key_exists($moduleBundle, self::$modules)) {
            continue;
        }
        self::$modules[$moduleBundle] = $moduleBundle;

        ## manifest
        $manifestFile = __DIR__.'/../../'.$moduleBundle.'/manifest.json';
        DAssert::assertFileExists($manifestFile, "$moduleBundle manifest file not exists.");

        $maniJson = file_get_contents($manifestFile);
        $manifest = json_decode($maniJson, true);
        DAssert::assertNotFalse($manifest, "$moduleBundle : illegal manifest json file");

        ## init
        $initFile = __DIR__.'/../../'.$moduleBundle.'/init.php';
        DAssert::assertFileExists($initFile);
        require_once $initFile;

        DAssert::assert(array_key_exists('main', $manifest), "$moduleBundle manifest need 'main' property");
        $main = $manifest['main'];
        DAssert::assert(class_exists($main, true), "$main class not exists");
        DAssert::assert(is_subclass_of($main, 'BaseModule'), "$main must be subclass of BaseModule");

        $main::init();
    }

}
