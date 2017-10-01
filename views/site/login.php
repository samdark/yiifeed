<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        
        <div class="col-sm-4 col-sm-offset-1">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]) ?>
            <h2>Fill out the following form</h2>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['class'=>'form-control input-lg']) ?>
                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control input-lg']) ?>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <p><?= Html::a('Forgot your password ?', ['site/request-password-reset']) ?></p>
        </div>
        
        <div class="col-sm-4 col-sm-offset-2 text-center github-side">
            <i class="fa fa-github fa-5x" aria-hidden="true"></i>
            <h3>Did you sign up with your<br>Github Account?</h3>
            <?= Html::a('Login with Github', ['/site/auth', 'authclient' => 'github'],['class' => 'btn btn-primary btn-lg btn-block']);?>
            <p class="text-muted">To connect your existing account<br>with Github, log in first.</p>
        </div>
    </div>
</div>

<div class="github-background">
    <div class="arrow"></div>
</div>
