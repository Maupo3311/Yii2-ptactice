<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Регистрация';
?>
    <h2>Регистрация</h2>
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-10">
            <?php
            $form = ActiveForm::begin();
            echo $form->field($registrationForm, 'login')->textInput(['autofocus' => true]);
            echo $form->field($registrationForm, 'password')->passwordInput();
            echo $form->field($registrationForm, 'confirm')->passwordInput();
            echo $form->field($registrationForm, 'name')->textInput();
            echo $form->field($registrationForm, 'surname')->textInput();
            echo $form->field($registrationForm, 'sex')->radioList(['1' => 'Мужчина', '2' => 'Женщина'], ['style' => 'margin-left: 20px']);
            echo Html::submitButton('Зарегестрировать', ['class' => 'btn btn-primary col-md-6']);
            ActiveForm::end();
            ?>
        </div>
    </div>