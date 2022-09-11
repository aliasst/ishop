<?php

namespace app\controllers;

use wfm\App;

class LanguageController extends AppController
{
    public function changeAction ()
    {
        //debug(App::$app->getProperties());
        //echo App::$app->getProperty('language')['code'];
        //die();

        $lang = get('lang', 's');
        echo $lang;

        if ($lang) {
            if(array_key_exists($lang, App::$app->getProperty('languages'))){
                $url = trim(str_replace(PATH, '', $_SERVER['HTTP_REFERER']), '/');
                $url_parts = explode('/', $url, 2);


                if(array_key_exists($url_parts[0], App::$app->getProperty('languages'))){
                    // присваиваем первой части новый язык, если он не базовый
                    if($lang != App::$app->getProperty('language')['code']){
                        $url_parts[0] = $lang;
                    } else {
                        // если это базовый язык, удалим язык
                        array_shift($url_parts);
                    }

                } else {
                    
                    // присваиваем первой части новый язык, если он не базовый
                    if($lang != App::$app->getProperty('language')['code']){
                        array_unshift($url_parts, $lang);
                    }
                }
                //debug($url);
                //debug($url_parts);
                //die;
                $url = PATH . '/' . implode('/', $url_parts);
                redirect($url);
            }
        }
        redirect();
    }
}