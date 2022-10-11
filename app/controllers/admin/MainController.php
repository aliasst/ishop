<?php

namespace app\controllers\admin;

use wfm\Controller;

class MainController extends AppController
{
    public function indexAction () {
        $title = 'Главная страница';
        $this->setMeta('Администрирование');
        $this->set(compact('title'));
    }
}