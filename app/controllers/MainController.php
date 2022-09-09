<?php

namespace app\controllers;

use app\models\Main;
use RedBeanPHP\R;
use wfm\Controller;

/** @property Main $model */

class MainController extends AppController
{
    public function indexAction () {

        $slides = R::findAll('slider');

        $names = $this->model->get_names();



        $this->setMeta("Главная", 'Описание для главной страницы', 'Главная, магазин');


        $this->set(compact('slides'));
    }
}