<?php

namespace app\models;

use RedBeanPHP\R;

class Main extends AppModel
{
        public function get_names() {
            return R::findAll('name');
        }
}