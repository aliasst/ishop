<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class Product extends AppModel
{
        public function get_products($lang, $start, $perpage)
        {
            return R::getAll("SELECT p.*, pd.title FROM product p JOIN product_description pd on p.id = pd.product_id WHERE pd.language_id =? LIMIT $start, $perpage", [$lang['id']]);
        }

    public function get_downloads($q): array
    {
        $data = [];
        $downloads = R::getAssoc("SELECT download_id, name FROM download_description WHERE name LIKE ? LIMIT 10", ["%{$q}%"]);
        if ($downloads) {
            $i = 0;
            foreach ($downloads as $id => $title) {
                $data['items'][$i]['id'] = $id;
                $data['items'][$i]['text'] = $title;
                $i++;
            }
        }
        return $data;
    }


    public function product_validate(): bool
    {
        $errors = '';
        if(!is_numeric($_POST['price'])){
            $errors .= 'Цена должна быть цифровым значением<br>';
        }
        if(!is_numeric($_POST['old_price'])){
            $errors .= 'Старая цена должна быть цифровым значением<br>';
        }

        foreach($_POST['product_description'] as $lang_id => $item){
            $item['title'] = trim($item['title']);
            $item['exerpt'] = trim($item['exerpt']);
            if(empty($item['title'])){
                $errors .= "Не заполнено наименование во вкладке {$lang_id}<br>";
            }
            if(empty($item['exerpt'])){
                $errors .= "Не заполнено краткое описание во вкладке {$lang_id}<br>";
            }
        }

        if($errors){
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }



}