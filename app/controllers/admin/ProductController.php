<?php

namespace app\controllers\admin;

use app\models\admin\Product;
use RedBeanPHP\R;
use wfm\App;
use wfm\Pagination;

/** @property Product $model */
class ProductController extends AppController
{
    public function indexAction () {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = R::count('product');



        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();
        $products = $this->model->get_products($lang, $start, $perpage);
        $title = 'Список товаров';
        $this->setMeta('Список товаров');
        $this->set(compact('title', 'products', 'total', 'pagination'));
    }

}