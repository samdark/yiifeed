<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('header'); ?>
<div class="header-title"> 
<div class="container">
    <h4><?= $this->title ?></h4>
</div>
</div>
<?php $this->endBlock(); ?>


<div class="site-signup">
    <div class="row">
        
        <div class="col-sm-4 col-sm-offset-2">
            <h2>Fill out the following form</h2>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['class'=>'form-control input-lg']) ?>
                <?= $form->field($model, 'email')->textInput(['class'=>'form-control input-lg']) ?>
                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control input-lg']) ?>
                <div class="form-group">
                    <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-sm-4 col-sm-offset-1 text-center well github-well">
            <i class="fa fa-github fa-5x" aria-hidden="true"></i>
            <h3>Did you sign up with your<br>Github Account?</h3>
            <?= Html::a('Login with Github', ['/site/auth', 'authclient' => 'github'],['class' => 'btn btn-primary btn-lg btn-block']);?>
            <p class="text-muted">To connect your existing account<br>with Github, log in first.</p>
        </div>

    </div>
</div>
