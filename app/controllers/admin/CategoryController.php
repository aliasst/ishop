<?php

namespace app\controllers\admin;

class CategoryController extends AppController
{

    public function indexAction() {

        $title = 'Список категорий';
        $this->setMeta('Список категорий');
        $this->set(compact('title'));
    }

}