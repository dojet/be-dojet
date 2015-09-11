<?php
namespace Dojet;

require_once(DLIB.'IAutoloader.class.php');
require DMODEL.'MAutoloadPath.class.php';

class DAutoloader implements IAutoloader {

    protected $autoloadPath;
    protected $namespacePath = array();

    protected static $instance;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DAutoloader();
        }
        return self::$instance;
    }

    function __construct() {
        $this->autoloadPath = new MAutoloadPath();
    }

    public function addAutoloadPath($autoloadPath) {
        $this->autoloadPath->addAutoloadPath($autoloadPath);
    }

    public function addAutoloadPathArray($arrAutoloadPath) {
        $this->autoloadPath->addAutoloadPathArray($arrAutoloadPath);
    }

    public function autoloadPaths() {
        return $this->autoloadPath->autoloadPaths();
    }

    public function autoload($className) {
        if (strpos($className, '\\') !== false) {
            return $this->autoload_namespace($className);
        }

        return $this->autoloadClassFile($className, $this->autoloadPath);
    }

    protected function autoload_namespace($nsClassName) {
        $ns = strtok($nsClassName, '\\');
        $ref = $this->namespacePath;
        while (false !== $ns) {
            if (!isset($ref[$ns])) {
                return false;
            }
            $ref = $ref[$ns];
            if ($ref instanceof MAutoloadPath) {
                $nslist = explode('\\', $nsClassName);
                $className = array_pop($nslist);
                return $this->autoloadClassFile($className, $ref);
            }
            $ns = strtok('\\');
        }
    }

    protected function autoloadClassFile($className, MAutoloadPath $autoloadPath) {
        foreach ($autoloadPath->autoloadPaths() as $path) {
            $filepath = $path.$className.'.class.php';
            if (file_exists($filepath)) {
                require_once($filepath);
                return true;
            }
        }
        return false;
    }

    public function addNamespacePath($namespace, $path) {
        $ns = strtok($namespace, '\\');
        $ref = &$this->namespacePath;
        while (false !== $ns) {
            if (!isset($ref[$ns])) {
                $ref[$ns] = array();
            }
            $ref = &$ref[$ns];
            $ns = strtok('\\');
        }

        if (!is_null($ref) && $ref instanceof MAutoloadPath) {
            $autoloadPath = $ref;
            $autoloadPath->addAutoloadPath($path);
        } else {
            $autoloadPath = new MAutoloadPath();
            $autoloadPath->addAutoloadPath($path);
            $ref = $autoloadPath;
        }

    }

    public function addNamespacePathArray($namespace, $arrPath) {
        foreach ($arrPath as $path) {
            $this->addNamespacePath($namespace, $path);
        }
    }

}
