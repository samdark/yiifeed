<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\News $model
 * @var yii\widgets\ActiveForm $form
 */

\app\assets\MarkdownEditorAsset::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'news-form']) ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => 250, 'class' => 'form-control input-lg']) ?>
<?= $form->field($model, 'text')->textarea() ?>

<?= $form->field($model, 'link')->textInput(['maxlength' => 250, 'class' => 'form-control input-lg']) ?>

<?php if (\app\components\UserPermissions::canAdminNews()): ?>
    <?= $form->field($model, 'status')->dropDownList(\app\models\News::getStatuses(), ['class' => 'form-control input-lg']) ?>
<?php endif ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('news', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end() ?>