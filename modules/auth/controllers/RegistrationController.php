<?php

namespace app\modules\auth\controllers;

use yii\web\Controller;

class RegistrationController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

}
