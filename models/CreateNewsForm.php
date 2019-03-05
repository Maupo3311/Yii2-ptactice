<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class CreateNewsForm extends Model
{
    public $text;
    public $files;

    public function attributeLabels()
    {
        return [
            'text' => 'Текст новости',
            'files' => 'Прикрепить фаил',
        ];
    }

    public function rules(){
        return [
            ['text', 'required'],
            ['files', 'file', 'extensions' => 'jpg, png', 'maxFiles' => 8],
        ];
    }

    public function fillingTheModel($model){
        $this->text = str_replace('<', '&lt;', $this->text);
        $this->text = str_replace('>', '&gt;', $this->text);

        $model->text = $this->text;
        $model->id_of_the_sender = Yii::$app->user->getId();
    }

    public function saveFile($id_news){
        $this->files = UploadedFile::getInstances($this, 'files');
        if( !empty($this->files) ){
            foreach($this->files as $file){
                FileHelper::createDirectory('data/newses/' . $id_news);
                $file->saveAs('data/newses/' . $id_news . '/' . $file->baseName . '.' . $file->extension);
            }
        }
    }
}