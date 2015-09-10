<?php

class Config {

    private static $config;

    public static function loadConfig($confFile) {
        $filename = $confFile.'.conf.php';
        DAssert::assert(file_exists($filename), 'conf file not exist! '.$filename);
        require_once($filename);
    }

    /**
     * 通过keypath获取value
     * keypath是以'.'分割的字符串
     *
     * @param string $keyPath
     * @return mix
     */
    public static function configForKeyPath($keyPath, $config = null) {
        if (is_null($config)) {
            $config = self::$config;
        }

        return XPath::path($keyPath, $config);
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
