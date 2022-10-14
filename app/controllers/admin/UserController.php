<?php

namespace app\controllers\admin;

use app\models\admin\User;
use RedBeanPHP\R;
use wfm\Pagination;

/** @property User $model */
class UserController extends AppController
{
    public function loginAdminAction()
    {
        if ($this->model::isAdmin()) {
            redirect(ADMIN);
        }

        $this->layout = 'login';
        if (!empty($_POST)) {
            if ($this->model->login(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['errors'] = 'Логин/пароль введены неверно';
            }
            if ($this->model::isAdmin()) {
                redirect(ADMIN);
            } else {
                redirect();
            }
        }

    }

    public function logoutAction()
    {
        if ($this->model::isAdmin()) {
            unset($_SESSION['user']);
        }
        redirect(ADMIN . '/user/login-admin');
    }


    public function indexAction() {

        $page = get('page');
        $perpage = 20;
        $total = R::count('user');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $users = $this->model->get_users($start, $perpage);
        $title = 'Список пользователей';
        $this->setMeta('Список пользователей');
        $this->set(compact('title', 'pagination', 'users', 'total'));
    }


    public function viewAction()
    {
        $id = get('id');
        $user = $this->model->get_user($id);
        if(!$user){
            throw new \Exception('Такого пользователя не существует', 404);
        }

        $page = get('page');
        $perpage = 10;
        $total = $this->model->get_count_orders($id);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();



        $orders = $this->model->get_user_orders($start, $perpage, $id);
        $title = "Профиль пользователя";
        $this->setMeta("Профиль пользователя");
        $this->set(compact('title', 'user', 'pagination', 'orders', 'total'));

    }


    public function editAction ()
    {
        $id = get('id');
        $user = $this->model->get_user($id);
        if(!$user){
            throw new \Exception('Такого пользователя не существует', 404);
        }
        if(!empty($_POST))
        {
            if(empty($_POST['password'])){
                unset($_POST['password']);
            }

            $this->model->load($_POST);
            if(empty($this->model->attributes['password'])){
                unset($this->model->attributes['password']);
            }
            if(!$this->model->validate($this->model->attributes) || !$this->model->checkEmail($user)){
                $this->model->getErrors();
            } else {
                if(!empty($this->model->attributes['password'])) {
                    $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                }
                if($this->model->update('user', $id)){
                    $_SESSION['success'] = 'Пользователь сохранен. Перезайдите если вы обновляли свои данные';
                } else {
                    $_SESSION['errors'] = "Ошибка";
                }
            }

            redirect();
        }

        $title = "Редактирование пользователя";
        $this->setMeta("Редактирование пользователя");
        $this->set(compact('title', 'user'));
    }


    public function addAction() {

        if(!empty($_POST)) {
            $this->model->load();
            if(!$this->model->validate($this->model->attributes) || !$this->model->checkUnique('Такой email уже занят')){
                $this->model->getErrors();
                $_SESSION['form_data'] = $_POST;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if($this->model->save('user')){
                    $_SESSION['success'] = 'Пользователь добавлен';
                } else {
                    $_SESSION['errors'] = "Ошибка";
                }
            }
            redirect();
        }

        $title = "Добавление пользователя";
        $this->setMeta("Добавление пользователя");
        $this->set(compact('title', ));
    }


}