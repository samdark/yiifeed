<?php

namespace app\controllers;
use app\components\feed\Feed;
use app\components\feed\Item;
use app\components\UserPermissions;
use app\models\Comment;
use app\notifier\NewCommentNotification;
use app\notifier\NewSuggestionNotification;
use app\notifier\Notifier;
use Yii;
use app\models\News;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * NewsController
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['suggest', 'admin', 'update', 'delete'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['suggest', 'update'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['admin', 'delete'],
                        'roles' => [UserPermissions::ADMIN_NEWS],
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['status'=>News::STATUS_PUBLISHED])->orderBy('created_at DESC'),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionSuggest()
    {
        $model = new News([
            'status' => News::STATUS_PROPOSED,
            'scenario' => News::SCENARIO_SUGGEST
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $notifier = new Notifier(new NewSuggestionNotification($model));
            $notifier->sendEmails();
            Yii::$app->session->setFlash('news.news_successfully_added');
            return $this->redirect(['index']);
        }

        return $this->render('suggest', [
            'model' => $model,
        ]);
    }

    public function actionRss()
    {
        /** @var News[] $news */
        $news = News::find()->where(['status' => News::STATUS_PUBLISHED])->orderBy('created_at DESC')->limit(50)->all();

        $feed = new Feed();
        $feed->title = 'YiiFeed';
        $feed->link = Url::to('/', true);
        $feed->selfLink = Url::to(['news/rss'], true);
        $feed->description = 'Yii news';
        $feed->language = 'en';
        $feed->setWebMaster('sam@rmcreative.ru', 'Alexander Makarov');
        $feed->setManagingEditor('sam@rmcreative.ru', 'Alexander Makarov');

        foreach ($news as $post) {
            $item = new Item();
            $item->title = $post->title;
            $item->link = Url::to($post->getUrl(), true);
            $item->guid = Url::to($post->getUrl(), true);
            $item->description = HtmlPurifier::process(Markdown::process($post->text));

            if (!empty($post->link)) {
                $item->description .= Html::a(Html::encode($post->link), $post->link);
            }

            $item->pubDate = $post->created_at;
            $item->setAuthor('noreply@yiifeed.com', 'YiiFeed');
            $feed->addItem($item);
        }

        $feed->render();
    }

    /**
     * @param int $status
     * @return string
     */
    public function actionAdmin($status)
    {
        $query = News::find()->orderBy('created_at DESC');
        $query->andWhere(['status' => $status]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('admin',[
            'status' => $status,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string|Response
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!UserPermissions::canEditNews($model)) {
            throw new ForbiddenHttpException('You are not allowed to edit this news.');
        }

        if (UserPermissions::canAdminNews()) {
            $model->scenario = News::SCENARIO_ADMIN;
        } else {
            $model->scenario = News::SCENARIO_UPDATE;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($model->getUrl());
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin', 'status' => 1]);
    }

    /**
     * @param int $id
     * @param string $slug
     *
     * @return string|Response
     */
    public function actionView($id, $slug = null)
    {
        $news = $this->findModel($id);
        
        if ($slug === null || $news->slug !== (string) $slug) {
            return $this->redirect($news->getUrl(), 301);
        }
        
        $commentForm = new Comment();
        $commentForm->news_id = $news->id;
        if ($commentForm->load(Yii::$app->request->post()) && $commentForm->save()) {
            $this->notifyAboutComment($news, $commentForm);
            return $this->refresh('#c' . $commentForm->id);
        }

        return $this->render('view', [
            'model' => $news,
            'commentForm' => $commentForm,
        ]);
    }

    /**
     * @param News $news
     * @param Comment $comment
     */
    private function notifyAboutComment(News $news, Comment $comment)
    {
        $users = [];

        // news author
        if ($comment->user_id !== $news->user_id) {
            $users[] = $news->user;
        }

        foreach ($news->comments as $existingComment) {
            if ($comment->user_id !== $existingComment->user_id) {
                $users[] = $existingComment->user;
            }
        }


        foreach ($users as $user) {
            $notifier = new Notifier(new NewCommentNotification($comment, $user));
            $notifier->sendEmails();
        }
    }

    /**
     * @param int $id
     * @return null|News
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
