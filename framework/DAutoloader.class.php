<?php
require_once(DLIB.'IAutoloader.class.php');

class DAutoloader implements IAutoloader {

    protected $autoloadPaths = array();

    protected static $instance;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DAutoloader();
        }
        return self::$instance;
    }

    public function addAutoloadPath($autoloadPath) {
        $key = md5($autoloadPath);
        $this->autoloadPaths[$key] = $autoloadPath;
    }

    public function addAutoloadPathArray($arrAutoloadPath) {
        foreach ($arrAutoloadPath as $autoloadPath) {
            $this->addAutoloadPath($autoloadPath);
        }
    }

    public function getAutoloadPath() {
        return $this->autoloadPaths;
    }

    public function autoload($className) {
        foreach ($this->autoloadPaths as $path) {
            $filepath = $path.$className.'.class.php';
            if (file_exists($filepath)) {
                require_once($filepath);
                return true;
            }
        }
    }

}
