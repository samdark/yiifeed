<?php
/**
 * @var $model app\models\News
 */
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;
?>
<div class="row">
    <div class="col-xs-2 post-meta">
        <p class="time">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?= Yii::$app->formatter->asDate($model->created_at) ?>
        </p>
    </div>
    <div class="col-xs-10 post">
        <h1>
            <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?>
        </h1>

        <div class="content">
            <?= StringHelper::truncateWords(Markdown::process($model->text), 70) ?>
        </div>

        <div class="meta">
            <?php if (!empty($model->link)): ?>
                <p><?= Html::a(Html::encode($model->link), $model->link) ?></p>
            <?php endif ?>
        </div>
    </div>
</div>