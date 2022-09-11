<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use wfm\App;
use wfm\Controller;

class AppController extends Controller
{
        public function __construct($route = [])
        {
            parent::__construct($route);
            new AppModel();
            App::$app->setProperty('languages', Language::getLanguages());
            App::$app->setProperty('language',  Language::getLanguage(App::$app->getProperty('languages')));
            //debug(App::$app->getProperty('languages'));
            //debug(App::$app->getProperty('language'));
            //echo App::$app->getProperty('language')['code'];
            $lang = App::$app->getProperty('language')['code'];
            \wfm\Language::load($lang, $this->route);
            //debug(\wfm\Language::$lang_data);


            //die();
        }
}