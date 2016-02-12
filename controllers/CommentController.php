<?php


namespace app\controllers;


use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

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
                'only' => ['index'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['adminNews'],
                    ],
                ],
            ],
        ];
    }

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
}
