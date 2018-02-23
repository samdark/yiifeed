<?php

namespace app\controllers;

use app\components\UserPermissions;
use app\models\Comment;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CommentController
 */
class CommentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [UserPermissions::ADMIN_NEWS],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Comment::find()->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $comment = $this->findModel($id);
        
        if (!UserPermissions::canManageComment($comment)) {
            throw new ForbiddenHttpException(Yii::t('comment', 'You can not delete this comment.'));
        }

        if ($comment->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('comment', 'Comment deleted.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('comment', 'Failed to delete comment.'));
        }

        $backUrl = Yii::$app->request->referrer ?: Url::to($comment->news->getUrl());

        return $this->redirect($backUrl);
    }

    /**
     * Finds model by id, throws 404 if not found
     *
     * @param integer $id
     * @return Comment
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
