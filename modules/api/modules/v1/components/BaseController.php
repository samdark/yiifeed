<?php

namespace app\modules\api\modules\v1\components;

use Yii;
use app\modules\api\modules\v1\models\User;
use app\modules\api\modules\v1\Module;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\rest\Serializer;
use yii\web\Request;
use yii\web\Response;

/**
 * @property Response $response
 * @property Request $request
 * @property User $currentUser
 * 
 * @property Module $module
 */
class BaseController extends Controller
{
    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'items',
    ];
    
    /**
     * @var User|bool
     */
    private $_currentUser;

    public function init()
    {
        parent::init();
        
        $this->response->on(Response::EVENT_BEFORE_SEND, function ($event) {
            /** @var Response $response */
            $response = $event->sender;
            
            $response->data = [
                'status' => $response->isSuccessful ? 'ok' : 'error',
                'data' => $response->data,
            ];
        });
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['compositeAuth'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
                QueryParamAuth::class,
                [
                    'class' => HttpBasicAuth::class,
                    'auth' => function ($username, $password) {
                        $user = User::findByUsername($username);
                        if ($user && $user->validatePassword($password)) {
                            return $user;
                        }
                        
                        return null;
                    }
                ]
            ]
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
        ];

        return $behaviors;
    }
    
    /**
     * @return User
     */
    protected function getCurrentUser()
    {
        if ($this->_currentUser === null) {
            $this->_currentUser = User::findOne(Yii::$app->user->getId());
        }
        
        return $this->_currentUser;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->module->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->module->response;
    }
    
}
