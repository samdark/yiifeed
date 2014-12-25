<?php

namespace app\controllers;
use app\components\feed\Feed;
use app\components\feed\Item;
use Yii;
use app\models\News;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
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
                'only' => ['suggest', 'admin', 'create', 'update', 'delete'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['suggest'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['admin', 'create', 'update', 'delete'],
                        'roles' => ['adminNews'],
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
        $model = new News([
            'status' => News::STATUS_DRAFT,
            'scenario' => News::SCENARIO_SUGGEST
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('news.news_successfully_added');
            return $this->redirect(['index']);
        }

        return $this->render('suggest', [
            'model' => $model,
        ]);
    }

    public function actionRss()
    {
        header('Content-type: application/xml');

        /** @var News[] $news */
        $news = News::find()->where(['status' => News::STATUS_PUBLIC])->orderBy('id DESC')->limit(50)->all();

        $feed = new Feed();
        $feed->title = 'YiiFeed';
        $feed->link = Url::to('');
        $feed->selfLink = Url::to(['news/rss'], true);
        $feed->description = 'Yii news';
        $feed->language = 'en';
        $feed->setWebMaster('sam@rmcreative.ru', 'Alexander Makarov');
        $feed->setManagingEditor('sam@rmcreative.ru', 'Alexander Makarov');

        foreach ($news as $post) {
            $item = new Item();
            $item->title = $post->title;
            $item->link = Url::to(['news/view', 'id' => $post->id], true);
            $item->guid = Url::to(['news/view', 'id' => $post->id], true);
            $item->description = HtmlPurifier::process(Markdown::process($post->text));
            $item->pubDate = $post->created_at;
            $item->setAuthor('noreply@yiifeed.com', 'YiiFeed');
            $feed->addItem($item);
        }

        $feed->render();
    }

    public function actionAdmin($status = null)
    {
        $query = News::find()->orderBy('id DESC');

        if ($status !== null) {
            $query->andWhere(['status' => $status]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('admin',[
            'status' => $status,
            'dataProvider' => $dataProvider,
        ]);
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
