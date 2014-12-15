<?php

use yii\bootstrap\Button;
use yii\helpers\Markdown;
use yii\helpers\Html;
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news','News');
?>
<?php
if(!\Yii::$app->user->isGuest)
    echo yii\helpers\Html::a(Yii::t('news','Suggest news'),['news/suggest'],['class' => 'btn btn-success']);
?>



<?php

echo  \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}{pager}',
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_view'
]);