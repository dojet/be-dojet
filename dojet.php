<?php
define('DOJET_PATH', realpath(dirname(__FILE__)).'/');
define('FRAMEWORK', DOJET_PATH.'framework/');
define('DLIB',      DOJET_PATH.'lib/');
define('DMODEL',    DOJET_PATH.'model/');
define('DUTIL',     DOJET_PATH.'util/');

date_default_timezone_set('Asia/Chongqing');

include DLIB.'function.inc.php';
require FRAMEWORK.'DAutoloader.class.php';

$autoloader = DAutoloader::getInstance();
$autoloader->addAutoloadPathArray(
    array(
        FRAMEWORK, DLIB, DMODEL
    )
);
DAutoloader::addAutoloader($autoloader);

////////////////////////////////////////

function startWebService(WebService $webService) {
    $dojet = new Dojet();
    try {
        $dojet->start($webService);
    } catch (Exception $e) {
        $error = 'exception occured, msg: '.$e->getMessage().' errno: '.$e->getCode();
        println($error);
        Trace::fatal($error);
    }
}

function startCliService(CliService $cliService) {
    $dojet = new Dojet();
    $dojet->start($cliService);
}
