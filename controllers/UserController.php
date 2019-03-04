<?php

namespace app\controllers;

use app\models\AuthorizationForm;
use app\models\MyUser;
use yii\web\Controller;
use app\models\RegistrationForm;
use yii;

class UserController extends Controller
{
    public function actionIndex(){

        $authorizationForm = new AuthorizationForm();
        $userModel = new MyUser();

        $request = Yii::$app->request;
        $user = Yii::$app->user;
        $session = Yii::$app->session;

        if(!$user->isGuest){
            $this->goHome();
        }

        if( $authorizationForm->load($request->post())) {
            $currentUser = $userModel->getUserByCondition('login',  $authorizationForm->login);
            if( !empty($currentUser) ){
                if($currentUser['password'] ==  md5($authorizationForm->password)){

                    $user->login($currentUser, $authorizationForm->memory ? 3600 * 24 * 7 : 0);
                    $this->goHome();

                } else {
                    $session->setFlash('error', 'Неверный пароль');
                }
            } else {
                $session->setFlash('error', 'Неверный логин');
            }
        }

        return $this->render('index', compact('authorizationForm', 'currentUser', 'test'));
    }

    public function actionRegistration()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $registrationForm = new RegistrationForm();
        $userModel = new MyUser();

        if ($registrationForm->load($request->post()) && $registrationForm->validate()) {

            $registrationForm->fillingTheModel($userModel);
            $userModel->save();
            $this->redirect('/web?r=user');

        }
        return $this->render('registration', compact('registrationForm'));
    }

    public function actionLogout(){

        $user = Yii::$app->user;

        $user->logout();

        $this->goHome();

    }
}