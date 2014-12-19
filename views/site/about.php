<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About YiiFeed';
?>
<div class="site-about row">
    <div class="col-xs-2 page-meta hidden-sm hidden-xs">
        <span class="glyphicon glyphicon-fire icon" aria-hidden="true"></span>
    </div>
    <div class="col-xs-12 col-md-10 page">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>YiiFeed is community selected stream of news about <a href="http://www.yiiframework.com/">Yii framework</a>.
            News could be read both in browser and via RSS subscription.</p>

        <p>It was started in the end of 2014 both to serve as the place to get news about Yii in convenient way and
            as an educational project.</p>

        <h2>Project sources</h2>

        <p>Project will be open sourced at GitHub as soon as we'll polish it a bit more. Stay tuned.</p>

        <h2>Team</h2>

        <p>Currently we are Alexander Makarov and Cvigun Vadim. As soon as project will be opensourced anyone would
        be able to join.</p>

        <h2>Contacts</h2>

        <p>If you have any questions or ideas... basically anything. Feel free to <a href="mailto:sam+yiifeed@rmcreative.ru">contact Alexander</a>.</p>
    </div>
</div>
