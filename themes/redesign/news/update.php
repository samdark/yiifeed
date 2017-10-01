<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = Yii::t('news', 'Update {modelClass}: ', [
        'modelClass' => 'News',
    ]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('news', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('news', 'Update');
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

<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
