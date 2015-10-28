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

    public function start(Service $service) {
        DAssert::assert($service instanceof Service, 'service must be Service');
        $this->service = $service;
        $service->dojetDidStart();
    }

}
