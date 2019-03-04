<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Авторизация';
    $this->registerCssFile('css/user/authorization.css');

?>
<h2>Авторизация</h2>
<div class="row justify-content-center align-items-center">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <?php
        $form = ActiveForm::begin();
        echo $form->field( $authorizationForm, 'login' )->textInput(['autofocus' => true]);
        echo $form->field( $authorizationForm, 'password' )->input('password');
        echo $form->field( $authorizationForm, 'memory' )->checkbox();
        echo Html::submitButton('Войти', ['class' => 'btn btn-primary col-md-6', 'id' => 'submit']);
        ActiveForm::end();
        ?>
        <div class="col-md-12">
            <br><p>Если вы все еще не имеете профиля, то <a href="?r=user/registration">зарегестрируйтесь</a></p>
        </div>
    </div>
</div>
<!--<div class="container" style="width: 40%">-->
<!--    <div class="row">-->
<!--        --><?php
//        $form = ActiveForm::begin();
//        echo $form->field( $authorizationForm, 'login')->textInput(['autofocus' => true]);
//        echo $form->field( $authorizationForm, 'password')->input('password');
//        echo Html::submitButton('Войти', ['class' => 'btn btn-primary col-md-6', 'id' => 'submit']);
//        ActiveForm::end();
//        ?>
<!--    </div>-->
<!--    <div class="row">-->
<!--       <br><p>Если вы все еще не имеете профиля, то <a href="?r=user/registration">зарегестрируйтесь</a></p>-->
<!--    </div>-->
<!--</div>-->
