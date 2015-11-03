<?php
/**
 * @author     Leeyan <setimouse@gmail.com>
 * @copyright  2009-2015 Leeyan.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    0.1
 */
class Dojet {

    public function start(Service $service) {
        $this->loadModules($service);
        $service->dojetDidStart();
    }

    protected function loadModules(Service $service) {
        $modules = $service->modules();
        foreach ($modules as $module) {
            ## manifest
            $manifestFile = __DIR__.'/../../'.$module.'/manifest.json';
            DAssert::assertFileExists($manifestFile, "$module manifest file not exists.");

            $maniJson = file_get_contents($manifestFile);
            $manifest = json_decode($maniJson, true);
            DAssert::assertNotFalse($manifest, "$module : illegal manifest json file");

            ## init
            $initFile = __DIR__.'/../../'.$module.'/init.php';
            DAssert::assertFileExists($initFile);
            require_once $initFile;

            DAssert::assert(array_key_exists('main', $manifest), "$module manifest need 'main' property");
            $main = $manifest['main'];
            DAssert::assert(class_exists($main, true), "$main class not exists");
            DAssert::assert(is_subclass_of($main, 'BaseModule'), "$main must be subclass of BaseModule");

            $main::init();
        }
    }

    protected function loadModule(BaseModule $module) {

    }

}
