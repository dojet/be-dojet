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

    public static function route($route, $action, $namespace = '') {
        self::$routes[$route] = array('action' => $action, 'namespace' => $namespace);
    }

    public static function loadRoute($routeConfig) {
        foreach ($routeConfig as $route => $config) {
            if (is_string($config)) {
                $action = $config;
                Dispatcher::route($route, $action);
            } elseif (is_array($config)) {
                DAssert::assertKeyExists('action', $config);
                DAssert::assertKeyExists('namespace', $config);
                Dispatcher::route($route, $config['action'], $config['namespace']);
            }
        }
    }

    public static function loadNamespaceRoute($namespace, $routeConfig) {
        foreach ($routeConfig as $route => $action) {
            DAssert::assertString($action);
            Dispatcher::route($route, $action, $namespace);
        }
    }

    public function dispatch($requestUri) {

        foreach (self::$routes as $routeRegx => $actionInfo) {
            if ( preg_match($routeRegx, $requestUri, $reg) ) {
                foreach ($reg as $key => $value) {
                    MRequest::setParam($key, $value);
                }

                $actionName = $actionInfo['action'];
                $namespace = $actionInfo['namespace'];

                $classFile = $actionName.'.class.php';

                DAssert::assert(file_exists($classFile),
                    'ui action does not exist, file='.$classFile, __FILE__, __LINE__);

                require_once($classFile);

                $className = $namespace.basename($actionName);
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
