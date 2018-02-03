<?php

use app\components\UserPermissions;
use app\widgets\Avatar;
use yii\helpers\Markdown;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * @var app\models\Comment[] $comments
 * @var yii\widgets\ActiveForm $form
 * @var app\models\Comment $commentForm
 */

\app\assets\MarkdownEditorAsset::register($this);

$commentCount = count($comments);
?>
<div class="row">
<div class="col-lg-offset-2 col-lg-7 col-md-offset-3 col-md-7 col-sm-offset-3 col-sm-9">

<h1 class="comment-count">Comments (<?= $commentCount ?>)</h1>

<?php if(!$commentCount): ?>
<p>No comments yet.</p>
<?php endif; ?>

<ol class="comments">
    <?php foreach ($comments as $comment): ?>
        <li id="c<?= $comment->id ?>" class="row">
            <div class="col-md-3 col-xs-6 author">
                <?= Html::a(Avatar::widget(['user' => $comment->user]) . ' <span class="user-handle">@' . Html::encode($comment->user->username) . '</span>', ['user/view', 'id' => $comment->user->id]) ?>
            </div>
            
            <div class="col-md-8 col-xs-4">
                <span class="date"><?= Yii::$app->formatter->asDate($comment->created_at) ?></span>
            </div>
            
            <?php if (UserPermissions::canManageComment($comment)): ?>
                <div class="col-md-1 col-xs-2">
                    <?= Html::a(
                        '<i class="fa fa-remove"></i> ' . Yii::t('comment', 'Delete'),
                        ['/comment/delete', 'id' => $comment->id], [
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('comment', 'Are you sure you want to delete this comment?'),
                        'class' => 'btn btn-danger'
                    ]) ?>
                </div>
            <?php endif ?>
            
            <div class="col-xs-12 text">
                <?= HtmlPurifier::process(Markdown::process($comment->text, 'gfm-comment'), [
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ]) ?>
            </div>
        </li>
    <?php endforeach ?>
</ol>

<?php if (!Yii::$app->user->isGuest): ?>

    <hr>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($commentForm, 'text')->label('Add new comment')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('news', 'Comment'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <p><b>Signup in order to comment.</b></p>
<?php endif ?>

</div>
</div>