<?php

use \yii\widgets\ListView;
use yii\bootstrap\Alert;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news','News');
?>
<div class="row news-index">
    <?php if (Yii::$app->session->hasFlash('news.news_successfully_added')) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::t('news','Your news sent for moderation'),
        ]);
    }?>
    <div class="col-xs-12">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view'
        ]) ?>
    </div>

</div>