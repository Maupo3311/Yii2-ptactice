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
    public function actionIndex(){

        $newsModel = new News();

        $fullNewses = array_reverse( $newsModel->find()->with('sender')->all() );

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
}