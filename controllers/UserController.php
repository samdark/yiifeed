<?php

namespace app\controllers;

use app\components\UserPermissions;
use Yii;
use app\models\User;
use app\models\News;
use yii\authclient\Collection;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'generate-access-token'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'roles' => [UserPermissions::ADMIN_USERS],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'generate-access-token' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays user profile
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var User $user */
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('No such user.');
        }

        $authClients = [];
        if (Yii::$app->user->id == $user->id) {
            // get clients user isn't connected with yet
            $auths = $user->auths;
            /** @var Collection $clientCollection */
            $clientCollection = Yii::$app->authClientCollection;
            $authClients = $clientCollection->getClients();
            foreach ($auths as $auth) {
                unset($authClients[$auth->source]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['user_id'=>$id])->orderBy('id DESC'),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('view', [
            'model' => $user,
            'dataProvider' => $dataProvider,
            'authClients' => $authClients,
        ]);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionGenerateAccessToken()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $user->scenario = User::SCENARIO_ACCESS_TOKEN;
        $user->generateAccessToken();
        
        if ($user->save()) {
            Yii::$app->session->setFlash('info', Yii::t('user', 'Make sure to copy your new personal access token now. You won\'t be able to see it again!'));
            Yii::$app->session->setFlash('success', Yii::t('user', 'Access token: {accessToken}', ['accessToken' => "<b>{$user->access_token}</b>"]));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Failed to generate new token.'));
        }
        
        return $this->redirect(['user/view', 'id' => $user->id]);
    }
    
}
