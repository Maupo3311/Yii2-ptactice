<?php
    use yii\bootstrap\Carousel;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Просмотр новости';
    $this->registerCssFile('css/news/showNewsById.css?'. time());
    $this->registerJsFile('web/js/news/basic.js?' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerCssFile('css/news/newses.css?' . time());
?>
<div class="col-md-1 col-xs-0"></div>
<div class="col-md-10 col-xs-12">
        <?php
        echo '<div class="newsBlock">';
        echo '<div class="newsSender">' . $news->sender->name . ' ' . $news->sender->surname . '</div>';
        echo '<div class="newsText">' . $news['text'] . '</div>';
        $path = 'data/newses/' . $news->id_news;
        if(file_exists($path)){
            $content = scandir($path);
            $content = array_slice($content, 2);
            $carousel = [];
            if( count($content) > 1 ){

                foreach($content as $file){
                    $carousel[] = [
                        'content' => '<img src="' . $path . '/' . $file . '" class="newsImage" style="height: 400px"/>',
                        'options' => []
                    ];

                }
                echo Carousel::widget([
                    'items' => $carousel,
                    'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                    ]
                ]);
            } else if( count($content) == 1 ){
                echo '<div class="bimg">';
                echo '<img src="' . $path . '/' . $content[0] . '" class="newsImage" style="height: 400px"/>';
                echo '</div>';
            }

        }
        echo '</div>';


        if($access){
            echo '<div id="options">';

            echo '<a href="#"><span class="optionsButton">Редактировать</span></a>';
            echo '<a href="#"><span class="optionsButton">Очистить коментарии</span></a>';
            echo '<a href="#"><span class="optionsButton">Удалить запись</span></a>';

            echo '</div>';
        }


        echo ' <div id="commentWindow">';
            foreach($comments as $comment){
                echo '<div class="commentBlock">';
                    echo '<div class="commentSender">' . $comment->sender->name . ' ' . $comment->sender->surname . '</div>';
                    echo '<div class="commentText">' . $comment->text . '</div>';
                echo '</div>';
            }
        echo '</div>';


        if(!$user->isGuest){
            $form = ActiveForm::begin([]);
            echo $form->field($commentForm, 'text')->textarea(['id' => 'newCommentText', 'placeholder' => 'Оставьте ваш комментарий...']);
            echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']);
            ActiveForm::end();
        }
        ?>
</div>