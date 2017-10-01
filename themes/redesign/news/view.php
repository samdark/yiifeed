<?php

use app\components\UserPermissions;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $commentForm app\models\Comment */

$this->params['breadcrumbs'][] = ['label' => Yii::t('news', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->title = $model->title;
?>


<?php $this->beginBlock('header'); ?>
<div class="header-title"> 
<div class="container">
  <?= Breadcrumbs::widget([
    'links' => $this->params['breadcrumbs'],
]) ?>
</div>
</div>
<?php $this->endBlock(); ?>

<div class="row news-view">

    <div class="col-xs-12">
        <?= $this->render('_view', [
            'isFull' => true,
            'model' => $model,
            'commentForm' => $commentForm,
            'displayModeratorButtons' => UserPermissions::canEditNews($model),
        ]) ?>
    </div>
</div>