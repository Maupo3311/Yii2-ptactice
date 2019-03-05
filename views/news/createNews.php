<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Новая новость';
    $this->registerCssFile('css/news/createNews.css');
    $this->registerJsFile('web/js/news/createNews.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<h2>Добавить новость</h2>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <?php
            $form = ActiveForm::begin();
            echo $form->field($createNewsForm, 'text')->textarea(['id' => 'textInput']);
            echo '<div id="fileInput">';
                echo $form->field($createNewsForm, 'files[]')->fileInput(['multiple' => true]);
            echo '</div>';
            echo Html::submitButton('Добавить', ['class' => 'btn btn-primary col-md-3', 'id' => 'submitInput']);
            ActiveForm::end();
            echo '<button data="close" class="btn btn-primary col-md-4" id="showFileInput">Прикрепить</button>';


        ?>
    </div>
</div>
