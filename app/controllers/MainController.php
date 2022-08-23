<?php

namespace app\controllers;

use wfm\Controller;

class MainController extends Controller
{
    public function indexAction () {

        $this->setMeta("Главная", 'Описание для главной страницы', 'Главная, магазин');
        $test = 'Тестовые даные';
        $this->set(compact('test'));
    }
}