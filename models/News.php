<?php

namespace app\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{
    public static function tableName(){
        return 'newses';
    }

    public function getSender(){
        return $this->hasOne(MyUser::className(), ['user_id' => 'id_of_the_sender']);
    }

    public function getComments(){
        return $this->hasMany(Comment::className(), ['id_news' => 'id_news']);
    }
}