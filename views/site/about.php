<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>YiiFeed is a selection of news about <a href="http://www.yiiframework.com/">Yii framework</a> selected by
    community. News could be read both in browser and via RSS subscription.</p>
</div>
