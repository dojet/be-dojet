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

    private static $modules = array();

    public static function module() {
        return SingletonFactory::getInstance(get_called_class());
    }

    final public static function init() {
        $depends = self::module()->depends();
        foreach ($depends as $module) {
            if (array_key_exists($module, self::$modules)) {
                continue;
            }
            self::$modules[$module] = $module;
            $moduleInit = __DIR__.'/../../'.$module.'/init.php';
            require $moduleInit;
        }
    }

    protected function depends() {
        return array();
    }

}
