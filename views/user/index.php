<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Users');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'email:email',
            ['attribute'=>'status','value'=>function ($model) {
                    return $model->getStatusLabel();
                }],
             ['attribute'=>'created_at','value'=>function ($model) {
                     return Yii::$app->formatter->asDate($model->created_at);
                 }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
