<?php

namespace wfm;

use RedBeanPHP\R;

class Db
{
    use Tsingleton;

    private function __construct() {
        $db = require_once CONFIG . '/config_db.php';
        R::setup($db['dsn'], $db['user'],$db['password']);

        if(!R::testConnection()){
            throw new \Exception('no db connection', '500');
        }
        R::freeze(true);
        if (DEBUG) {
            R::debug(true, 3);
        }
    }
}