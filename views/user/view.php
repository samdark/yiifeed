<?php

use app\components\UserPermissions;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $authClients \yii\authclient\ClientInterface[] */

$this->title = $model->username;

use \yii\widgets\ListView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */

?>

<?php $this->beginBlock('header'); ?>
<div class="header-title"> 
    <div class="container">
        <div class="row profile">
            <div class="col-sm-2">
                <div class="user-view-avatar">
                    <?= \app\widgets\Avatar::widget([
                        'user' => $model,
                        'size' => 165,
                    ]) ?>
                </div>
            </div>
            <div class="col-sm-10">
            <h2><?= Html::encode($this->title) ?></h2>
                <?php if ($model->getGithubProfileUrl() !== null): ?>
                    <?= Html::a(Html::encode($model->getGithubProfileUrl()), $model->getGithubProfileUrl(), ['class'=>'github-link'])?>
                <?php endif ?>

                <?php if (UserPermissions::canAdminUsers()): ?>
                    <p>
                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                <?php endif ?>

                <p><?= Html::a(Yii::t('user', 'Generate new access token for API'), ['user/generate-access-token'], [
                    'class' => 'btn btn-default',
                    'data-method' => 'post',
                ]) ?></p>
                
                <?php /** if (count($authClients) > 0): ?>
                <div class="col-sm-4">
                    <div class="well well-sm">
                        <h2>Connect extra profiles:</h2>
                        <?= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['site/auth'],
                            'popupMode' => false,
                            'clients' => $authClients,
                        ]) ?>
                    </div>
                </div>
                <?php endif  */ ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock(); ?>

<div class="row user-view">
    <div class="col-xs-12">

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'itemOptions' => [
                'class' => 'item',
            ],
            'itemView' => '/news/_view',
            'viewParams' => [
                'displayStatus' => true,
                'displayUser' => false,
            ],
        ]) ?>
    </div>
</div>
