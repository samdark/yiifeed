<?php
use app\models\News;
use \yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news', 'Comments admin');
?>
<div class="row news-index">
    <div class="col-xs-12">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_view',
            'viewParams' => [
                'displayModeratorButtons' => true,
            ],
        ]) ?>
    </div>

</div>