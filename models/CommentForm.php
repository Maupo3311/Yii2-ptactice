<?php

namespace app\models;

use yii\base\Model;
use Yii;

class CommentForm extends Model
{
    public $id_of_the_sender;
    public $id_news;
    public $text;

    public function attributeLabels()
    {
        return [
            'text' => 'Комментарий',
        ];
    }

    public function rules(){
        return [
            ['text', 'trim'],
        ];
    }

    public function fillingTheModel($model, $id_news){

        $this->text = str_replace('<', '&lt;', $this->text);
        $this->text = str_replace('>', '&gt;', $this->text);

        $model->text = $this->text;
        $model->id_of_the_sender = Yii::$app->user->getId();
        $model->id_news = $id_news;
    }
}