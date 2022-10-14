<?php

namespace app\controllers\admin;

use wfm\App;
use wfm\Cache;

class CacheController extends AppController
{
        public function indexAction()
        {
            $title = "Управление кешем";
            $this->setMeta("Управление кешем");
            $this->set(compact('title', ));
        }

        public function deleteAction()
        {
            $langs = App::$app->getProperty('languages');
            $cache_key = get('cache', 's');
            $cache = Cache::getInstance();
            if($cache_key == 'category'){

                foreach($langs as $lang => $item){

                    $cache->delete("ishop_menu_{$lang}");
                }
            }
            if($cache_key == 'page'){
                foreach($langs as $lang => $item){
                    $cache->delete("ishop_page_menu_{$lang}");
                }
            }
            $_SESSION['success'] = 'Выбранный кеш удален';
            redirect();
        }

}