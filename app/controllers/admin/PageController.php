<?php

namespace app\controllers\admin;

use app\models\admin\Page;
use RedBeanPHP\R;
use wfm\App;
use wfm\Pagination;

/** @property Page $model */
class PageController extends AppController
{
        public function indexAction() {
            $lang = App::$app->getProperty('language');
            $page = get('page');
            $perpage = 10;
            $total = R::count('page');
            $pagination = new Pagination($page, $perpage, $total);
            $start= $pagination->getStart();
            $pages = $this->model->getPages($lang, $start, $perpage);

            $title = "Список страниц";
            $this->setMeta("Список страниц");
            $this->set(compact('title', 'pagination', 'pages', 'total'));
        }

        public function deleteAction()
        {
            $id = get('id');
            if($this->model->deletePage($id)){
                $_SESSION['success'] = "Страница удалена успешно";
            } else {
                $_SESSION['errors'] = "Ошибка при удалении страницы";
            }
            redirect();

        }


        public function addAction()
        {
            if(!empty($_POST)) {
                if($this->model->page_validate()) {
                    if($this->model->save_page()) {
                        $_SESSION['success'] = "Страница добавлена";
                    } else {
                        $_SESSION['errors'] = "Ошибка! Страница не добавлена";
                    }

                }
                redirect();
            }

            $title = "Новая страница";
            $this->setMeta("Новая страница");
            $this->set(compact('title'));
        }


        public function editAction()
        {
            $id = get('id');
            if(!empty($_POST)){
                if($this->model->page_validate()){
                    if($this->model->update_page($id)) {
                        $_SESSION['success'] = "Страница обновлена";
                    } else {
                        $_SESSION['errors'] = "Ошибка! Страница не обновлена";
                    }
                }
                redirect();
            }

            $page = $this->model->get_page($id);
            if(!$page){
                throw new \Exception('Нет такой страницы', 404);
            }
            $title = "Редактирование страницы";
            $this->setMeta("Редактирование страницы");
            $this->set(compact('title', 'page'));

        }



}