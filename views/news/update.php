<?php

use yii\helpers\Html;

app\assets\HighlightInitAsset::register($this);
$this->registerJs("marked.setOptions({
            highlight: function (code) {
                return hljs.highlightAuto(code).value;
            }
        });");

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = Yii::t('news', 'Update {modelClass}: ', [
        'modelClass' => 'News',
    ]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('news', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('news', 'Update');
?>
<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>