<?php
/**
 * @var $model app\models\News
 */
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;
use \yii\helpers\HtmlPurifier;

$isFull = isset($isFull) ? $isFull : false;
$displayStatus = isset($displayStatus) ? $displayStatus : false;
$displayModeratorButtons = isset($displayModeratorButtons) ? $displayModeratorButtons : false;
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

        <?php if ($displayModeratorButtons): ?>
            <?= Html::a(Yii::t('news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('news', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </div>
    <div class="col-sm-9 col-md-10 post">
        <h1>
            <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?>
        </h1>

        <div class="content">
            <?php
            $text = HtmlPurifier::process(Markdown::process($model->text));
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