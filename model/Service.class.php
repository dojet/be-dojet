<?php
/**
 *
 * @author setimouse@gmail.com
 * @since 2014 5 2
 */
abstract class Service {

    public function dojetDidStart() {}

    public function classCachePath() {
        return sys_get_temp_dir();
    }

}
