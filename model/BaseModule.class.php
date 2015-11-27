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

    public static function module() {
        return SingletonFactory::getInstance(get_called_class());
    }

    final public static function init() {

    }

}
