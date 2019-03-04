<?php

namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName(){
        return 'comments';
    }

    public function getSender(){
        return $this->hasOne(MyUser::className(), ['user_id' => 'id_of_the_sender']);
    }

    public function getNews(){
        return $this->hasOne(News::className(), ['id_news' => 'id_news']);
    }
}