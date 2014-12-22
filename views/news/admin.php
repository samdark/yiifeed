<?php
use app\models\News;
use \yii\widgets\ListView;
use yii\bootstrap\Alert;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news', 'News admin');
?>
<div class="row news-index">
    <div class="col-xs-12">
        <?= \yii\bootstrap\Nav::widget([
            'options' => ['class' => 'nav-pills'],
            'items' => [
            [
                'label' => 'Drafts',
                'url' => ['news/admin', 'status' => News::STATUS_DRAFT],
                'active' => $status == News::STATUS_DRAFT,
            ],
            [
                'label' => 'Deleted',
                'url' => ['news/admin', 'status' => News::STATUS_DELETED],
                'active' => $status == News::STATUS_DELETED,
            ],
            [
                'label' => 'Published',
                'url' => ['news/admin', 'status' => News::STATUS_PUBLIC],
                'active' => $status == News::STATUS_PUBLIC,
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