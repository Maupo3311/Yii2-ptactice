<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Редактирование новости';
    $this->registerCssFile('css/news/createNews.css');
    $this->registerJsFile('web/js/news/createNews.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<h2>Редактирование новости</h2>

<div class="col-md-2"></div>
<div class="col-md-8 ">
    <?php
    $form = ActiveForm::begin();
    echo $form->field($createNewsForm, 'text')->textarea(['id' => 'textInput']);
    if($numberOfFiles != 0){
        echo '<p>Прикрепленных фаилов - ' . $numberOfFiles . '</p>';
    }
    echo '<div id="fileInput">';
    echo $form->field($createNewsForm, 'files[]')->fileInput(['multiple' => true]);
    echo '</div>';
    echo Html::submitButton('Добавить', ['class' => 'btn btn-primary col-md-3', 'id' => 'submitInput']);
    ActiveForm::end();

    if($availabilityOfFiles){
        echo '<button class="btn btn-primary" onclick="MyAlert(\'deleteNewsFiles\', ' . $news->id_news .')">Очистить фаилы</button>';
    } else {
        echo '<button data="close" class="btn btn-primary col-md-4" id="showFileInput">Прикрепить</button>';
    }


    ?>
</div>