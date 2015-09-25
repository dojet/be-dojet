<?php
/**
 * @author     Leeyan <setimouse@gmail.com>
 * @copyright  2009-2015 Leeyan.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    0.1
 */
class Dojet {

    /**
     * @var Service
     **/
    protected $service;

    protected static $instance;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Dojet();
        }
        return self::$instance;
    }

    public function start(Service $service) {
        DAssert::assert($service instanceof Service, 'service must be Service');
        $this->service = $service;
        $service->dojetDidStart();
    }

    public function addAutoloader(IAutoloader $autoloader) {
        spl_autoload_register(array($autoloader, 'autoload'));
    }

    public function removeAutoloader(IAutoloader $autoloader) {
        spl_autoload_unregister(array($autoloader, 'autoload'));
    }

}
