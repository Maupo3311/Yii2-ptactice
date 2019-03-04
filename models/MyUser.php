<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class MyUser extends ActiveRecord implements IdentityInterface
{
    public static function tableName(){
        return 'users';
    }


    public function getUserByCondition($field, $condition){
        return $this->find()->where([$field => $condition])->all()[0];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}