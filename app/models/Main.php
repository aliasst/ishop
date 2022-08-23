<?php

namespace app\models;

use RedBeanPHP\R;

class Main extends \wfm\Model
{
        public function get_names() {
            return R::findAll('name');
        }
}