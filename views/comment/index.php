<?php
use app\models\News;
use \yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
$this->title = Yii::t('news', 'Comments admin');
?>


<?php $this->beginBlock('header'); ?>
<div class="header-title"> 
<div class="container">
    <h4>Comments</h4>
</div>
</div>
<?php $this->endBlock(); ?>


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