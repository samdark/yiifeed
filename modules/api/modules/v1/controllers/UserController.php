<?php

namespace app\modules\api\modules\v1\controllers;

use Yii;
use app\components\UserPermissions;
use app\modules\api\modules\v1\components\BaseController;
use app\modules\api\modules\v1\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class UserController extends BaseController
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
                    'actions' => ['view'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => [UserPermissions::ADMIN_USERS],
                ],
            ]
        ];

        return $behaviors;
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find()->sortByDefault()
        ]);
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = $this->findUser($id);

        if (UserPermissions::canEditUser($user) || (int) $user->status === User::STATUS_ACTIVE) {
            return $user;    
        }
        
        throw new ForbiddenHttpException('You should be authorized in order to manage user.');
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws NotFoundHttpException
     */
    protected function findUser($id)
    {
        /** @var User $user */
        $user = User::findOne($id);

        if ($user) {
            return $user;
        }
        
        throw new NotFoundHttpException("The requested user does not exist");
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
