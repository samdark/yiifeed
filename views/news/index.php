<?php

use yii\grid\GridView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
//        'id',
        'title',
        'text:ntext',
        'link',
//        'status',
         'created_at',
    ],
]); ?>
