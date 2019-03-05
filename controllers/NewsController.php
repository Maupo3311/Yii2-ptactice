<?php

namespace app\controllers;

use app\models\Comment;
use app\models\CommentForm;
use app\models\MyUser;
use app\models\News;
use yii\web\Controller;
use app\models\CreateNewsForm;
use Yii;

class NewsController extends Controller
{
    public function actionIndex($condition = null){

        $user = Yii::$app->user;
        $newsModel = new News();

        if($condition == 'myNewses'){
            $fullNewses = array_reverse( $newsModel->find()->where(['id_of_the_sender' => $user->getId()])->with('sender')->all() );
        } else {
            $fullNewses = array_reverse( $newsModel->find()->with('sender')->all() );
        }

        return $this->render('index', compact('fullNewses', 'newsModel'));
    }

    public function actionCreateNews(){

        $request = Yii::$app->request;

        $createNewsForm = new CreateNewsForm();
        $newsModel = new News();

        if( $createNewsForm->load($request->post()) && $createNewsForm->validate() ){
            $createNewsForm->fillingTheModel($newsModel);
            $newsModel->save();
            $createNewsForm->saveFile($newsModel->id_news);
            $this->redirect('?r=news/index');
        }

        return $this->render('createNews', compact('createNewsForm'));
    }

    public function actionShowNewsById($id){

        $commentModel = new Comment();
        $commentForm = new CommentForm();
        $newsForm = new CreateNewsForm();
        $newsModel = new News();
        $user = Yii::$app->user;

        if($commentForm->load(Yii::$app->request->post()) && $commentForm->validate()){
            $commentForm->fillingTheModel($commentModel, $id);
            $commentModel->save();
            $this->refresh();
        }

        $news = $newsModel::find()->where(['id_news' => $id])->one();
        $comments  = array_reverse( Comment::find()->where(['id_news' => $news->id_news])->with('sender')->all() );

        if( $user->identity->status == 'admin' ){
            $access = true;
        } else if( $user->getId() == $news->id_of_the_sender ){
            $access = true;
        } else {
            $access = false;
        }

        $newsForm->text = $news->text;

        return $this->render('showNewsById', compact('commentForm', 'newsForm', 'news', 'sender', 'user', 'access', 'comments'));
    }

    public function actionDeleteNews($id){

        $user = Yii::$app->user;
        $news = News::findOne($id);

        $path = 'data/newses/' . $id;
        if( file_exists($path) ){

            $files = array_slice(scandir($path), 2);
            foreach($files as $file){
                unlink($path . '/' . $file);
            }

            rmdir($path);
        }

        if($user->identity->status != 'admin' && $user->getId() != $news->id_of_the_sender){
            return 'Вы не можете удалить эту новость!';
        }



        $news->delete();

        $this->redirect('?r=news/index');
    }

    public function actionUpdateNews($id, $deleteFiles = false){
        $user = Yii::$app->user;
        $createNewsForm = new CreateNewsForm();
        $news = News::findOne($id);

        if($user->identity->status != 'admin' && $user->getId() != $news->id_of_the_sender){
            return 'Вы не можете редактировать эту новость!';
        }

        $path = 'data/newses/' . $id;
        $availabilityOfFiles = ( file_exists($path) ) ? true : false;
        $numberOfFiles = ($availabilityOfFiles) ? count( scandir($path) ) - 2 : 0;

        if($deleteFiles){
            if( $availabilityOfFiles ){

                $files = array_slice(scandir($path), 2);
                foreach($files as $file){
                    unlink($path . '/' . $file);
                }

                rmdir($path);
                $availabilityOfFiles = false;
            }
        }

        if( $createNewsForm->load(Yii::$app->request->post()) && $createNewsForm->validate() ){
            $news->text = $createNewsForm->text;
            $news->save();
            $createNewsForm->saveFile($news->id_news);
            $this->redirect('?r=news/index');
        }

        $createNewsForm->text = $news->text;

        return $this->render('updateNews', compact('news', 'createNewsForm', 'availabilityOfFiles', 'numberOfFiles'));
    }

}