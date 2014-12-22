<?php
/**
 * @var $model app\models\News
 */
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;

$isFull = isset($isFull) ? $isFull : false;
$displayStatus = isset($displayStatus) ? $displayStatus : false;
?>
<div class="row">
    <div class="col-md-2 col-sm-3 post-meta">
        <p class="time">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?= Yii::$app->formatter->asDate($model->created_at) ?>
        </p>

        <?php if ($displayStatus): ?>
        <p><?= Yii::t('news', 'Status') .": ". $model->getStatusLabel() ?></p>
        <?php endif ?>
    </div>
    <div class="col-sm-9 col-md-10 post">
        <h1>
            <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?>
        </h1>

        <div class="content">
            <?php
            $text = Markdown::process($model->text);
            echo $isFull ? $text : StringHelper::truncateWords($text, 70, '<p>' . Html::a('Read more', ['view', 'id' => $model->id]) . '</p>', true);
            ?>

            <?php if ($isFull): ?>
            <div class="meta">
                <?php if (!empty($model->link)): ?>
                    <p><?= Html::a(Html::encode($model->link), $model->link) ?></p>
                <?php endif ?>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>