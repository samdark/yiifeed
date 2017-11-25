<?php

namespace app\modules\api\components;

use Yii;
use yii\base\Module;
use yii\web\Request;
use yii\web\Response;

/**
 *
 * @property Request $request
 * @property Response $response
 */
class BaseModule extends Module
{
    public function init()
    {
        parent::init();

        \Yii::$app->user->enableSession = false;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return Yii::$app->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return Yii::$app->response;
    }
    
}
