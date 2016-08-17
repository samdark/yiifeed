<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\News $model
 * @var ActiveForm $form
 */

\app\assets\MarkdownEditorAsset::register($this);
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
