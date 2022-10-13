<?php

namespace app\controllers\admin;

use app\models\admin\Order;
use RedBeanPHP\R;
use wfm\Pagination;

/** @property Order $model */

class OrderController extends AppController
{

    public function indexAction()
    {
        $status = get('status', 's');
        $status = ($status == 'new') ? 'status = 0' : '';

        $page = get('page');
        $perpage = 10;
        $total = R::count('orders', $status);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();
        $orders = $this->model->get_orders($start, $perpage, $status);
        $title = "Список всех заказов";
        $this->setMeta('Список всех заказов');
        $this->set(compact('title', 'pagination', 'orders', 'total'));
    }

}