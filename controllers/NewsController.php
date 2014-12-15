<?php

namespace app\controllers;
use Yii;
use app\models\News;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class NewsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => [], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'rss'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'suggest', 'rss', 'admin', 'create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['status'=>News::STATUS_PUBLIC])->orderBy('id DESC'),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSuggest()
    {
        $model = new News(['scenario' => News::SCENARIO_SUGGEST]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('news.news_successfully_added');
                return $this->redirect(['add']);
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionRss()
    {
        header('Content-type: application/xml');
        $news = News::find()->where(['status' => News::STATUS_PUBLIC])->orderBy('id DESC')->limit(50)->all();

        return $this->renderPartial('rss', [
            'news' => $news
        ]);
    }

    public function actionAdmin()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['status' => News::STATUS_PUBLIC])->orderBy('id DESC'),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('admin',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new News();
        $model->scenario = 'insert';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
