<?php

use app\components\UserPermissions;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $commentForm app\models\Comment */

$this->title = $model->title;
?>
<div class="row news-view">

    <div class="col-xs-12">
        <?= $this->render('_view', [
            'isFull' => true,
            'model' => $model,
            'commentForm' => $commentForm,
            'displayModeratorButtons' => UserPermissions::canEditNews($model),
        ]) ?>
    </div>
</div>