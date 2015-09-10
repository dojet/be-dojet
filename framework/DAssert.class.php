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

    /**
     * 数字断言
     *
     * @param mix $var
     */
    public static function assertIntNumeric($var) {
        DAssert::assert(is_numeric($var), 'nan, '.var_export($var, true));
    }

    public static function assertNumeric($var) {
        DAssert::assert(is_numeric($var), 'nan, '.var_export($var, true));
    }

    /**
     * 数字数组断言
     *
     * @param mix $array
     */
    public static function assertNumericArray($array) {
        DAssert::assert(is_array($array), 'not an array');

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
        DAssert::assertNumericArray($array);
        DAssert::assert(!empty($array), 'array should not be empty');
    }

}