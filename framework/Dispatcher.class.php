<?php
class Dispatcher implements IDispatcher {

    protected static $routes = array();

    /**
     * @var BaseWebService
     **/
    private $webService;

    function __construct(WebService $webService) {
        $this->webService = $webService;
    }

    public static function addRoute($route, $action) {
        self::$routes[$route] = $action;
    }

    public function dispatch($requestUri) {
        $routes = self::$routes;

        foreach ($routes as $routeRegx => $actionName) {
            if ( preg_match($routeRegx, $requestUri, $reg) ) {
                foreach ($reg as $key => $value) {
                    MRequest::setParam($key, $value);
                }

                $classFile = $actionName.'.class.php';

                DAssert::assert(file_exists($classFile),
                    'ui action does not exist, file='.$classFile, __FILE__, __LINE__);

                require_once($classFile);

                $className = basename($actionName);
                $action = new $className;

                DAssert::assert($action instanceof BaseAction,
                    'action is not BaseAction. '.$actionName);

                $action->execute();

                return ;
            }
        }

        header('HTTP/1.1 404 Not Found');

    }

}
