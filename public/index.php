<?php
if(PHP_MAJOR_VERSION < 8) {
    die('Необходим php 8');
}


require_once dirname(__DIR__) .'/config/init.php';

new \wfm\App();

var_dump(\wfm\App::$app->getProperties());
