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

    public function addAction() {

        if(!empty($_POST)){
           if($this->model->product_validate()){
                $_SESSION['success'] = "Товар добавлен";
            }
            redirect();
        }


        $title = 'Добавление товара';
        $this->setMeta('Добавление товара');
        $this->set(compact('title'));
    }

    public function getDownloadAction() {
        $q = get('q', 's');
        $downloads = $this->model->get_downloads($q);
        echo json_encode($downloads);
        die;
    }



}