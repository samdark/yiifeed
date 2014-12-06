<?php
/**
 * @var $model app\models\News
 */
    use yii\helpers\Html;
    use yii\helpers\StringHelper;
    use yii\helpers\Markdown;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Html::a(Html::encode($model->title),['view','id'=>$model->id]); ?></h3>
    </div>
    <div class="panel-body">
        <?php echo   StringHelper::truncateWords(Markdown::process($model->text),70); ?>
       <?php if(!empty($model->link)){?> <p><?php echo Html::a(Html::encode($model->link),$model->link); ?></p><?php } ?>
        <p></p>
    </div>
    <div class="panel-footer">
    <span class="text-left"><?php echo date('Y-m-d',Html::encode($model->created_at)); ?></span>
    <span class="pull-right"><?php echo Html::a(Yii::t('news','Show more'),['view','id'=>$model->id]); ?></span>
    </div>
</div>