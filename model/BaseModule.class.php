<?php
/**
 * description
 *
 * Filename: BaseModule.class.php
 *
 * @author liyan
 * @since 2015 7 16
 */
abstract class BaseModule {

    protected static $config;

    public static function module() {
        return SingletonFactory::getInstance(get_called_class());
    }

    final public static function init($config) {
        static::$config = $config;
    }

    public static function config($keypath, $value = null) {
        if (is_null($value)) {
            return Config::configForKeyPath($keypath, static::$config);
        }
    }

}
