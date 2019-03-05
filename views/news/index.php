<?php
    use yii\bootstrap\Carousel;


    $this->title = 'Новости';
    $this->registerCssFile('css/basic.css');
    $this->registerCssFile('css/news/newses.css');
    $this->registerJsFile('web/js/news/basic.js?' . time(), ['depends' => [\yii\web\JqueryAsset::className()]]);
    $user = Yii::$app->user;

?>
<div id="imgBanner">
    <img src="images/0_3aa67_7ce248f0_XXL.jpg">
</div>
<div class="row">
    <div class="col-md-3" id="leftMenu">
        <a data-status="close" id="showSearch" class="menuButton" href="#"><p>Найти новость</p></a>
        <form id="searchForm" method="GET">
            <input id="searchText" class="col-md-8" type="text" name="search" placeholder="Найти...">
            <input id="searchButton" class="col-md-4" type="submit" value="Найти">
        </form>
        <a class="menuButton" href="?r=news/index"><p>Все новости</p></a>
        <?php
            if( !$user->isGuest ){
                echo '<a class="menuButton" href="?r=news/index&condition=myNewses"><p>Мои новости</p></a>';
                echo '<a class="menuButton" href="?r=news/create-news"><p>Добавить новость</p></a>';
            }
        ?>
    </div>
    <div class="col-md-9 col-sm-12" id="content">
        <?php
        $count = 0;
        foreach($fullNewses as $news){
            $carousel = [];
            echo '<div class="newsBlock">';
                echo '<a class="newsHref" href="?r=news/show-news-by-id&id=' . $news->id_news . '"><div class="newsSender">' . $news->sender->name . ' ' . $news->sender->surname . '</div></a>';
                echo '<div class="newsText">' . $news['text'] . '</div>';
                $path = 'data/newses/' . $news->id_news;
                if(file_exists($path)){
                    $content = scandir($path);
                    $content = array_slice($content, 2);

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
        }
        ?>
    </div>
</div>
