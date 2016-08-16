<?php
\app\assets\CodeMirrorAsset::register($this);
\app\assets\MarkdownEditorAsset::register($this);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;
/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(['id' => 'news-form']); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>
    <?= $form->field($model, 'text')->textarea() ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'status')->dropDownList(\app\models\News::getStatuses()) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('news', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>