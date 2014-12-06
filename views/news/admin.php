<?php
use yii\grid\GridView;
use yii\helpers\Markdown;
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'title',
//        'text:ntext',
        ['attribute' => 'text','format'=>'html', 'value'=>function ($model) {
                return Markdown::process($model->text);
            }],
        'link',
//        'status',
        ['attribute' => 'created_at','format'=>'text', 'value'=>function ($model) {
                return date('Y-m-d H:i:s',$model->created_at);
            }],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>