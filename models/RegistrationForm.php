<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $login;
    public $password;
    public $confirm;
    public $name;
    public $surname;
    public $sex;

    public function attributeLabels()
    {
        return ['login' => 'Логин', 'password' => 'Пароль', 'confirm' => 'Подтвердите пароль', 'name' => 'Имя', 'surname' => 'Фамилия', 'sex' => 'Ваш пол : '];
    }

    public function rules()
    {
        return [
            [['login', 'password', 'confirm', 'name', 'surname', 'sex'], 'required'],
            [['login', 'password', 'confirm', 'name', 'surname'], 'trim'],
            [['name', 'surname'], 'string', 'length' => [4, 28]],
            [['login', 'password'], 'string', 'length' => [6, 18]],
            ['confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['login', 'loginEmployment']
        ];
    }

    public function fillingTheModel($model)
    {
        $model->login = $this->login;
        $model->password = md5($this->password);
        $model->name = $this->name;
        $model->surname = $this->surname;
        $model->sex = $this->sex;
        $model->status = 'user';
    }

    public function loginEmployment($attribute, $type = null){
        $similarLogin = MyUser::find()->where(['login' => $this->login])->asArray()->all();

        if( !empty($similarLogin) ){
            $this->addError($attribute, 'Логин занят');
        }
    }

}