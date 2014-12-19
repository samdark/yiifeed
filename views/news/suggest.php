<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use ijackua\lepture\Markdowneditor;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form ActiveForm */
?>
<?php if (Yii::$app->session->hasFlash('news.news_successfully_added')) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success',
        ],
        'body' => Yii::t('news','Your news sent for moderation'),
    ]);
}?>
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
