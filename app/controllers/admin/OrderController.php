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


    public function editAction() {
        $id = get('id');
        if(isset($_GET['status'])){
            $status = get('status');
            if($this->model->change_status($id, $status)){
                $_SESSION['success'] = "Cтатус изменен";
            } else {
                $_SESSION['errors'] = "Ошибка! Cтатус не изменен";
            }

        }

        $order = $this->model->get_order($id);
        if(!$order){
            throw new \Exception('Нет такого заказа', 404);
        }
        $title = "Заказ №{$id}";
        $this->setMeta('Редактирование заказа');
        $this->set(compact('title', 'order'));

    }

}