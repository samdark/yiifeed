<?php

use \yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news','News');
?>
<div class="row news-index">

    <div class="col-xs-12">
        <div class="controls">
        <?php
        if (!\Yii::$app->user->isGuest) {
            echo yii\helpers\Html::a('<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> ' . Yii::t('news', 'Suggest news'), ['news/suggest'], ['class' => 'btn btn-success']);
        }
        ?>
        </div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view'
        ]) ?>
    </div>

</div>