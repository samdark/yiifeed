<?php

use yii\grid\GridView;
use yii\bootstrap\Button;

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
        'text:ntext',
        'link',
//        'status',
         'created_at',
    ],
]); ?>
