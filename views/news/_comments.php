<?php
/* @var $comments app\models\Comment[] */
/* @var $form yii\widgets\ActiveForm */
/* @var $commentForm app\models\Comment */
?>

<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<h2>Comments</h2>

<ol class="comments">
<?php foreach ($comments as $comment): ?>
    <li id="c<?= $comment->id ?>">
        <h3><?= Html::encode($comment->user->username) ?></h3>
        <?= \yii\helpers\Markdown::process($comment->text) ?>
    </li>
<?php endforeach ?>
</ol>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'text')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('news', 'Comment'), ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
