<?php

namespace app\modules\api\modules\v1\controllers;

use Yii;
use app\modules\api\modules\v1\models\User;
use app\modules\api\modules\v1\Module;
use app\modules\api\modules\v1\components\BaseController;
use yii\filters\AccessControl;
use yii\helpers\Url;

class DefaultController extends BaseController
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
                    'actions' => ['index', 'profile'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actionIndex()
    {
        return [
            'version' => Module::VERSION,
            'docsUrl' => Url::to(['/api/docs'], true),
            '_links' => [
                'news' => [
                    'href' => Url::to(['news/index'], true),
                ],
                'users' => [
                    'href' => Url::to(['user/index'], true),
                ],
            ],
        ];
    }

    /**
     * @return User
     */
    public function actionProfile()
    {
        return $this->currentUser;
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'profile' => ['GET', 'HEAD'],
        ];
    }
    
}
