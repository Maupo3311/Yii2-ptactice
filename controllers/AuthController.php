<?php

namespace app\controllers;

use app\models\MyUser;
use yii\web\Controller;
use Yii;

class AuthController extends Controller
{
    public function actionIndex($x=null){
        $userModel = new MyUser();

        Yii::$app->session->open();

        $user = $userModel->findOne(1);
        if($x == 'e'){
            Yii::$app->user->logout();
        } else {
//            Yii::$app->user->login(MyUser::findIdentity(1));
        }

        if(Yii::$app->user->isGuest){
            return Yii::$app->user->getId() . ' + Гость';
        } else {
           return Yii::$app->user->getId() . ' + Пользователь + ' . MyUser::findIdentity(1)['surname'];
        }
    }
}