<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\app\assets\CodeMirrorAsset::register($this);
\app\assets\MarkdownEditorAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form ActiveForm */
?>

<div class="news-add">

    <?php $form = ActiveForm::begin(['id' => 'news-add']) ?>
        <?= $form->field($model, 'link') ?>

        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'text')->textarea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end() ?>

</div>
