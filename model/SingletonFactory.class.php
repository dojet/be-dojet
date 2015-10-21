<?php
/**
 * @author liyan
 * @since 2015 10 21
 */
class SingletonFactory {

    private static $singletons = array();

    public static function getInstance($className) {
        $key = md5($className);
        if (!array_key_exists($key, self::$singletons)) {
            DAssert::assert(class_exists($className, true), "class $className not exists");
            self::$singletons[$key] = new $className;
        }
        return self::$singletons[$key];
    }

}
