<?php

namespace app\modules\api\modules\v1\controllers;

use app\modules\api\modules\v1\models\NewsSearch;
use Yii;
use app\components\UserPermissions;
use app\modules\api\modules\v1\components\BaseController;
use app\modules\api\modules\v1\models\News;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class NewsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                ],
            ],
        ];
        
        return $behaviors;
    }
    
    /**
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $newsSearch = new NewsSearch($this->currentUser, UserPermissions::canAdminNews());
        $dataProvider = $newsSearch->search(Yii::$app->request->queryParams);
        
        return $dataProvider;
    }

    /**
     * @param int $id
     *
     * @return News
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
        $news = $this->findNews($id);
        
        if (UserPermissions::canEditNews($news) || (int) $news->user_id === (int) $this->currentUser->id) {
            return $news;
        }
        
        throw new ForbiddenHttpException('You should be authorized in order to manage news.');
    }

    /**
     * @param int $id
     *
     * @return News
     * @throws NotFoundHttpException
     */
    protected function findNews($id)
    {
        /** @var News $user */
        $news = News::findOne($id);

        if ($news) {
            return $news;
        }

        throw new NotFoundHttpException("The requested news does not exist");
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
        ];
    }
    
}
