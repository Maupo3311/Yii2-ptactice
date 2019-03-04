<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.02.2019
 * Time: 14:26
 */

namespace app\models;


use yii\base\Model;

class AuthorizationForm extends Model
{
    public $login;
    public $password;
    public $memory;

    public function attributeLabels(){
        return ['login' => 'Логин', 'password' => 'Пароль', 'memory' => 'Запомнить пользователя'];
    }

    public function rules(){
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'trim'],
            ['memory', 'boolean'],
        ];
    }
}