<?php

namespace app\controllers;

use app\models\Main;
use wfm\Controller;

/** @property Main $model */

class MainController extends Controller
{
    public function indexAction () {

       $names = $this->model->get_names();
       debug($names);

        $this->setMeta("Главная", 'Описание для главной страницы', 'Главная, магазин');
        $test = 'Тестовые даные';
        $this->set(compact('test'));
    }
}