<?php

namespace app\controllers\admin;

use app\models\admin\Category;
use RedBeanPHP\R;
use wfm\App;

/** @property Category $model */
class CategoryController extends AppController
{

    public function indexAction()
    {

        $title = 'Список категорий';
        $this->setMeta('Список категорий');
        $this->set(compact('title'));
    }

    public function deleteAction()
    {
        $id = get('id');
        $errors = '';
        $children = R::count('category', 'parent_id = ?', [$id]);
        $products = R::count('product', 'category_id = ?', [$id]);
        if($children){
            $errors  .= "Ошибка! В категории есть вложенные категории<br>";
        }
        if($products){
            $errors  .= "Ошибка! В категории есть товары";
        }
        if($errors){
            $_SESSION['errors'] = $errors;
            redirect();
        }
        R::exec("DELETE FROM category WHERE id = ?", [$id]);
        R::exec("DELETE FROM category_description WHERE category_id = ?", [$id]);

        $_SESSION['success'] = 'Категория удалена';
        redirect();
    }

    public function addAction()
    {
        if(!empty($_POST)){

            if($this->model->category_validate())
            {
                if($this->model->save_category()){
                    $_SESSION['success'] = 'Категория сохранена';
                } else {
                    $_SESSION['errors'] = 'Ошибка! Категория не сохранена';
                }

            }
            redirect();

        }
        $title = 'Добавить категорию';
        $this->setMeta('Добавить категорию');
        $this->set(compact('title'));
    }

    public function editAction(){
        $id = get('id');
        if(!empty($_POST)) {
            if($this->model->category_validate()) {
                if ($this->model->update_category($id)) {
                    $_SESSION['success'] = 'Категория обновлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка! Категория не обновлена';
                }
            }
            redirect();
        }

        $category = $this->model->get_category($id);
        if(!$category){
            throw new \Exception('Not category', 404);
        }
        $lang = App::$app->getProperty('language')['id'];
        App::$app->setProperty('parent_id', $category[$lang]['parent_id']);
        $title = "Редактирование категории - {$category[$lang]['title']}";
        $this->setMeta($title);
        $this->set(compact('title', 'category'));

    }

}