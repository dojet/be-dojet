<?php
class DAssert {

    /**
     * 封装断言
     *
     * @param bool $condition
     * @param string $message
     */
    public static function assert($condition, $message = null) {

        if ($condition) {
            return ;
        }

        $backtrace = debug_backtrace();
        $file = $line = '';
        foreach ($backtrace as $trace) {
            if ($trace['class'] !== 'DAssert') {
                break;
            }
            $file = $trace['file'];
            $line = $trace['line'];
        }

        Trace::fatal('assert failed. '.$message.', '.$file.', '.$line);
        println('assert failed. '.$message.', '.$file.', '.$line);

        // assert($condition);
        die();
    }

    public static function assertNumeric($var) {
        $args = func_get_args();
        foreach ($args as $var) {
            DAssert::assert(is_numeric($var), 'nan, '.var_export($var, true));
        }
    }

    /**
     * 数字数组断言
     *
     * @param mix $array
     */
    public static function assertNumericArray($array) {
        DAssert::assertArray($array);
        foreach ($array as $val) {
            DAssert::assertIntNumeric($val);
        }
    }

    /**
     * 非空数字数组断言
     *
     * @param mix $array
     */
    public static function assertNotEmptyNumericArray($array) {
        DAssert::assert(!empty($array), 'array should not be empty');
        DAssert::assertNumericArray($array);
    }

    public static function assertArray($var, $message = null) {
        DAssert::assert(is_array($var), defaultNullValue($message, 'not an array'));
    }

    public static function assertKeyExists($key, $array, $message = null) {
        DAssert::assert(array_key_exists($key, $array), defaultNullValue($message, 'key not exists'));
    }

    public static function assertFileExists($filename, $message = null) {
        DAssert::assert(file_exists($filename), defaultNullValue($message, "$filename not exists"));
    }

    public static function assertNotFalse($condition, $message = null) {
        DAssert::assert(false !== $condition, defaultNullValue($message, "value can not be false"));
    }

    public static function assertString($var, $message = null) {
        DAssert::assert(is_string($var), defaultNullValue($message, 'not a string'));
    }

}
