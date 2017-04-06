<?php
class Config {

    private static $config;

    public static function loadConfig($confFile) {
        $filename = sprintf("%s.%s.conf.php", $confFile, MRuntime::currentRuntime());
        if (!file_exists($filename)) {
            $filename = $confFile.'.conf.php';
        }
        DAssert::assert(file_exists($filename), 'conf file not exist! '.$filename);
        require_once($filename);
    }

    public static function set($keyPath, $value, &$config = null) {
        $key = strtok($keyPath, '.');
        if (is_null($config)) {
            $config = &self::$config;
        }
        while ($key) {
            if (!is_array($config)) {
                $config = array();
            }

            if (!key_exists($key, (array)$config)) {
                $config[$key] = null;
            }
            $config = &$config[$key];
            $key = strtok('.');
        }
        $config = $value;
    }

    /**
     * 通过keypath获取value
     * keypath是以'.'分割的字符串
     *
     * @param string $keyPath
     * @return mix
     */
    public static function configForKeyPath($keyPath, $config = null, $default = null) {
        if (is_null($config)) {
            $config = self::$config;
        }
        $value = XPath::path($keyPath, $config);
        if (is_null($value)) {
            $value = $default;
        }
        return $value;
    }

    public static function &configRefForKeyPath($keyPath) {
        $key = strtok($keyPath, '.');
        $value = &self::$config;
        while ($key) {
            if (!is_array($value)) {
                $value = array();
            }

            if (!key_exists($key, (array)$value)) {
                $value[$key] = null;
            }
            $value = &$value[$key];
            $key = strtok('.');
        }
        return $value;
    }

    /**
     * 获取runtime下的配置项信息
     *
     * @param string $keyPath
     * @param string $runtime
     * @return mix
     */
    public static function runtimeConfigForKeyPath($keyPath, $runtime = null) {
        ($runtime !== null) or $runtime = Config::configForKeyPath('runtime');
        if (false !== strpos($keyPath, '.$.')) {
            $runtimeKeypath = str_replace('.$.', '.'.$runtime.'.', $keyPath);
        } else {
            $runtimeKeypath = $keyPath.'.'.$runtime;
        }
        return Config::configForKeyPath($runtimeKeypath);
    }

}
