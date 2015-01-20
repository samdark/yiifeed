<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use ijackua\lepture\Markdowneditor;

app\assets\HighlightInitAsset::register($this);
$this->registerJs("marked.setOptions({
            highlight: function (code) {
                return hljs.highlightAuto(code).value;
            }
        });");

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form ActiveForm */
?>

<div class="news-add">

    <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'link') ?>

        <?= $form->field($model, 'title') ?>

        <?= Markdowneditor::widget([
            'model' => $model,
            'attribute' => 'text',
        ]) ?>

    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end() ?>

</div>
