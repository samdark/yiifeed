<?php

use yii\grid\GridView;
use yii\bootstrap\Button;
use yii\helpers\Markdown;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news','News');
?>
<?php
if(!\Yii::$app->user->isGuest)
    echo yii\helpers\Html::a(Yii::t('news','Add news'),['news/add'],['class' => 'btn btn-success']);
?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
//        'id',
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
    ],
]); ?>
