<?php
/**
 *
 * @author setimouse@gmail.com
 * @since 2014 5 2
 */
abstract class WebService extends Service {

    public function dispatcher() {
        return new Dispatcher($this);
    }

    public function dispatchFinished() {}

    public function requestUriWillDispatch($requestUri) {
        $requestUri = substr($requestUri, 1);
        return $requestUri;
    }

    public function dojetDidStart() {
        $requestUri = $this->requestUriWillDispatch($_SERVER['REQUEST_URI']);
        $dispatcher = $this->dispatcher();
        $dispatcher->dispatch($requestUri);
        $this->dispatchFinished();
    }

    abstract public function getActionPath();

    abstract public function getDispatchConf();

}