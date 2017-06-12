<?php
/**
 *
 * @author setimouse@gmail.com
 * @since 2014 5 2
 */
abstract class WebService extends Service {

    protected static $instance;

    public static function service() {
        if (is_null(static::$instance)) {
            $class = get_called_class();
            static::$instance = new $class();
        }
        return static::$instance;
    }

    abstract public function root();

    public function dispatcher() {
        return new Dispatcher($this);
    }

    protected function dispatchFinished() {}

    public function requestUriWillDispatch($requestUri) {
        $requestUri = substr($requestUri, 1);
        return $requestUri;
    }

    public function dojetDidStart() {
        $requestUri = $this->requestUriWillDispatch($_SERVER['REQUEST_URI']);
        $dispatcher = $this->dispatcher();
        DAssert::assert($dispatcher instanceof IDispatcher, 'illegal dispatcher');
        $dispatcher->dispatch($requestUri);
        $this->dispatchFinished();
    }

}
