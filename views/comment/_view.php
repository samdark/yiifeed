<?php
use app\models\Comment;
use app\widgets\Avatar;
use yii\helpers\Html;
use \yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $model Comment */
?>
<div class="row comment">
    <div class="col-md-2 col-sm-2 info">
    <p class="author">
    <?= Html::a(Avatar::widget(['user' => $model->user, 'size' => 48]), ['user/view', 'id' => $model->user->id]) ?>
    </p>
    <p class="twitter-handle">
    <?= Html::a('@' . Html::encode($model->user->username), ['user/view', 'id' => $model->user->id]) ?>
    </p>
    </div>
    <div class="col-md-6 col-sm-7 text ">

    <div class="row ">
        
        <div class="col-md-9 col-sm-9">
            <div class="well">
            <?= HtmlPurifier::process(Markdown::process($model->text, 'gfm-comment'), [
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <?= Html::a(
                '<i class="fa fa-remove"></i> ' . Yii::t('comment', 'Delete'),
                ['/comment/delete', 'id' => $model->id], [
                'data-method' => 'post',
                'data-confirm' => Yii::t('comment', 'Are you sure you want to delete this comment?'),
                'class' => 'btn btn-danger'
            ]) ?>
        </div>
        </div>
     </div>
    <div class="col-md-4 col-sm-2 details">
        <p>
        <a href="#c<?= $model->id ?>">#<?= $model->id ?></a>
        <span class="date"><?=Yii::$app->formatter->format($model->created_at, 'datetime')?></span>
        → <?= Html::a(Html::encode($model->news->title), $model->news->getUrl())?>
    </p>
    </div>
</div>
