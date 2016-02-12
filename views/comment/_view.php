<?php
use app\models\Comment;
use app\widgets\Avatar;
use yii\helpers\Html;
use \yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $model Comment */
?>
<div class="row">
    <div class="col-xs-1 author">
        <?= Html::a(Avatar::widget(['user' => $model->user]) . ' ' . Html::encode($model->user->username), ['user/view', 'id' => $model->user->id]) ?>
    </div>
    <div class="col-xs-8 text well">
        <?= HtmlPurifier::process(Markdown::process($model->text, 'gfm-comment'), [
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
    <div class="col-xs-3">
        <a href="#c<?= $model->id ?>">#<?= $model->id ?></a>
        <span class="date"><?=Yii::$app->formatter->format($model->created_at, 'datetime')?></span>

        → <?= Html::a(Html::encode($model->news->title), ['/news/view', 'id' => $model->news->id])?>
    </div>
</div>
