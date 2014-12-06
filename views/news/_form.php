<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;
/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>
    <?php
    echo Markdowneditor::widget(
        [
            'model' => $model,
            'attribute' => 'text',
        ])
    ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'status')->dropDownList(\app\models\News::getStatusesArray()) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('news', 'Create') : Yii::t('news', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>