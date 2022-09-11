<?php

namespace app\controllers;

use app\models\Main;
use RedBeanPHP\R;
use wfm\App;
use wfm\Controller;

/** @property Main $model */

class MainController extends AppController
{
    public function indexAction () {

        $lang = App::$app->getProperty('language');
        $slides = R::findAll('slider');
        $products = $this->model->get_hits($lang, 3);

        $this->setMeta("Главная", 'Описание для главной страницы', 'Главная, магазин');


        $this->set(compact('slides', 'products'));
    }
}