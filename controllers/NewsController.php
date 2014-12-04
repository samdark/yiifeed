<?php

namespace app\controllers;

use app\models\News;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['status'=>News::STATUS_PUBLIC])->orderBy('id DESC'),
            'pagination' => array('pageSize' => 10),
        ]);

        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd()
    {
        $model = new News(['scenario'=>'user_insert']);

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                \Yii::$app->session->setFlash('news.news_successfully_added');
                $this->redirect(['add']);
                return true;
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

}
