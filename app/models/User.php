<?php

namespace app\models;

use Valitron\Validator;

class User extends AppModel
{
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'adress' => '',
    ];

    public array $rules = [
        'required' => ['email', 'password', 'name', 'address'],
        'email' => ['email',],
        'lengthMin' => [
            ['password', 6]
        ],
    ];

    public array $labels = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
        'adress' => 'tpl_signup_address_input',
    ];

    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }




}