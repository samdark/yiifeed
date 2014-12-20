<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
?>
<div class="row news-view">

    <div class="col-xs-12">
        <?php if(\Yii::$app->user->can('moderator')||\Yii::$app->user->can('admin')){ ?>
            <div class="controls">
                <?= Html::a(Yii::t('news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('news', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php } ?>
            <?= $this->render('_view', [
                'isFull' => true,
                'model' => $model,
            ]) ?>
    </div>
</div>