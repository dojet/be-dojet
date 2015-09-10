<?php
/**
 * trace delegate
 *
 * Filename: ITraceDelegate.class.php
 *
 * @author liyan
 * @since 2014 7 28
 */
interface ITraceDelegate {

    public function write($msg, $level, $file, $line);

}
