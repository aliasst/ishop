<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use RedBeanPHP\R;
use wfm\App;
use wfm\Pagination;

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
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_products($ids);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();


        $products = $this->model->get_products($ids, $lang, $start, $perpage);

        //debug($category);
        //debug($cats);
        //debug($products);

        $this->setMeta($category['title'], $category['description'], $category['keywords']);
        $this->set(compact('category','breadcrumbs', 'products', 'pagination', 'total'));

    }

}