<?php

namespace app\controllers\admin;

use RedBeanPHP\R;
use wfm\Controller;

class MainController extends AppController
{
    public function indexAction () {
        $title = 'Главная страница';
        $this->setMeta('Администрирование');
        $orders = R::count('orders');
        $new_orders = R::count('orders', 'status = 0');;
        $users = R::count('user');
        $products = R::count('product');
        $this->set(compact('title', 'orders', 'new_orders', 'users', 'products'));

    }
}