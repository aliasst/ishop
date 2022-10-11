<?php

namespace app\controllers\admin;

use RedBeanPHP\R;

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

}