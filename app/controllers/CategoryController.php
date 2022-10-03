<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use wfm\App;

/** @property Category $model */

class CategoryController extends AppController
{

    public function viewAction ()
    {
        $lang = App::$app->getProperty('language');
        $category = $this->model->get_category($this->route['slug'], $lang);
        if(!$category){
            $this->error_404();
            return;
        }
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category['id']);
        $cats = App::$app->getProperty("categories_{$lang['code']}");
        $ids = $this->model->getIds($category['id']);
        $ids = !$ids ? $category['id'] : $ids .= $category['id'];
        $products = $this->model->get_products($ids, $lang);

        //debug($category);
        //debug($cats);
        //debug($products);

        $this->setMeta($category['title'], $category['description'], $category['keywords']);
        $this->set(compact('category','breadcrumbs', 'products'));

    }

}