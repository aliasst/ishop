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
               if($this->model->save_product()) {
                   $_SESSION['success'] = "Товар добавлен";
               } else {
                   $_SESSION['errors'] = "Ошибка при добавлении товара";
               }
            }
            redirect();
        }


        $title = 'Добавление товара';
        $this->setMeta('Добавление товара');
        $this->set(compact('title'));
    }

    public function editAction()
    {
        $id = get('id');

        if(!empty($_POST)){

        }
        $product = $this->model->get_product($id);
        if(!$product){
            throw new \Exception('Not category', 404);
        }
        $gallery = $this->model->get_gallery($id);
        $lang = App::$app->getProperty('language')['id'];
        App::$app->setProperty('parent_id', $product[$lang]['category_id']);
        $title = 'Редактирование товара';
        $this->setMeta('Редактирование товара');
        $this->set(compact('title', 'product', 'gallery'));

    }

    public function getDownloadAction() {
        $q = get('q', 's');
        $downloads = $this->model->get_downloads($q);
        echo json_encode($downloads);
        die;
    }



}