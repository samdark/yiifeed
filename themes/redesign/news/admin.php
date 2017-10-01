<?php
use app\models\News;
use \yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news', 'News admin');
?>
<div class="row news-index">
    <div class="col-xs-12">
        <?= \yii\bootstrap\Nav::widget([
            'options' => ['class' => 'nav nav-tabs material-tabs'],
            'items' => [
            [
                'label' => News::statusLabel(News::STATUS_PROPOSED),
                'url' => ['news/admin', 'status' => News::STATUS_PROPOSED],
                'active' => $status == News::STATUS_PROPOSED,
            ],
            [
                'label' => News::statusLabel(News::STATUS_REJECTED),
                'url' => ['news/admin', 'status' => News::STATUS_REJECTED],
                'active' => $status == News::STATUS_REJECTED,
            ],
            [
                'label' => News::statusLabel(News::STATUS_PUBLISHED),
                'url' => ['news/admin', 'status' => News::STATUS_PUBLISHED],
                'active' => $status == News::STATUS_PUBLISHED,
            ],
          ],
        ]) ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view',
            'viewParams' => [
                'displayStatus' => true,
                'displayModeratorButtons' => true,
            ],
        ]) ?>
    </div>

</div>