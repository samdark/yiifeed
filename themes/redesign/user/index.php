<?php

use app\widgets\Avatar;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Users');
?>

<?php $this->beginBlock('header'); ?>
<div class="header-title"> 
<div class="container">
    <h4><?= $this->title ?></h4>
</div>
</div>
<?php $this->endBlock(); ?>

<div class="user-index">

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'format' => 'raw',
                    'label' => 'User',
                    'attribute' => 'username',
                    'value' => function ($model) {
                        return Html::a(Avatar::widget(['user' => $model]) . ' ' . Html::encode($model->username), ['user/view', 'id' => $model->id]);
                    }
                ],
                'email:email',
                [
                    'format' => 'raw',
                    'label' => 'GitHub',
                    'value' => function ($model) {
                        return Html::a(Html::encode($model->getGithubProfileUrl()), $model->getGithubProfileUrl());
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return $model->getStatusLabel();
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDate($model->created_at);
                    }
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
            ],
        ]
    ) ?>

</div>
