<?php
    $this->title = 'Главная страница';
    $user = Yii::$app->user;
    echo $user->identity['name'] . ' ' . $user->identity['surname'];

?>


