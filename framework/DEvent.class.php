<?php
/**
 * 事件
 *
 * @author liyan
 * @since 2015 7 16
 */
class DEvent {

    protected static $hooks = array();

    public static function doWhen($event, $callback) {
        DAssert::assert(is_callable($callback), 'callback must be callable');
        if (!key_exists($event, self::$hooks)) {
            self::$hooks[$event] = array();
        }
        array_push(self::$hooks[$event], $callback);
    }

    public static function remove($event, $callback) {
        if (!key_exists($event, self::$hooks)) {
            return ;
        }
        self::$hooks[$event] = array_diff(self::$hooks[$event], array($callback));
    }

    public static function happen($event) {
        if (!isset(self::$hooks[$event])) {
            return ;
        }

        $args = func_get_args();
        array_shift($args);

        foreach (self::$hooks[$event] as $callback) {
            call_user_func_array($callback, $args);
        }
    }

}