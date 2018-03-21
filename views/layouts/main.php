<?php
use app\components\UserPermissions;
use app\helpers\GoogleAnalytics;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\models\News;

/* @var $this \yii\web\View */
/* @var $content string */

$bundle = AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - YiiFeed</title>
    <link rel="alternate" type="application/rss+xml" title="YiiFeed" href="<?= \yii\helpers\Url::to(['news/rss'], true)?>"/>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="wrap">

<?php
            NavBar::begin([
                'brandLabel' => '<span class="glyphicon glyphicon-fire" aria-hidden="true"></span> YiiFeed',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            $menuItems = [
                '<form id="searchbox_006237035567373325440:lmymu4nwvsa" action="https://www.google.com/search" class="navbar-form navbar-left">
                    <fieldset class="form-group">
                        <input id="search_input" name="q" type="text" size="20" maxlength="256" class="form-control" placeholder="Search for...">
                        <input type="hidden" name="cx" value="006237035567373325440:lmymu4nwvsa">
                        <input type="hidden" name="cof" value="FORID:0">
                    </fieldset>
                </form>',
                ['label' => 'RSS', 'url' => ['/news/rss']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = ['label' => 'Comments', 'url' => ['/comment/index'], 'visible'=> \Yii::$app->user->can('adminNews')];
                $menuItems[] = ['label' => 'News admin', 'url' => ['/news/admin', 'status' => News::STATUS_PROPOSED], 'visible'=> \Yii::$app->user->can('adminNews')];
                $menuItems[] = ['label' => 'User admin', 'url' => ['/user/index'], 'visible'=> UserPermissions::canAdminUsers()];
                $menuItems[] = ['label' => Yii::$app->user->identity->username, 'url' => ['/user/view', 'id' => \Yii::$app->user->id], 'options' => ['class'=>'bolded']];
                $menuItems[] = [
                    'label' => 'Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            ?>

            <?= yii\helpers\Html::a(Yii::t('news', 'Suggest news'), ['news/suggest'], ['class' => 'btn btn-yellow navbar-btn']) ?>

            <?php
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

    <?php if (isset($this->blocks['header'])): ?>
        <?= $this->blocks['header'] ?>
    <?php endif; ?>
  
  <div class="container">
    <?= Alert::widget() ?>
    <?= $content ?>
  
</div>
</div>
<footer>
        <div class="container">
            <p class="pull-left">
                &copy; YiiFeed <?= date('Y') ?> |
                <?= Html::a('Twitter', 'https://twitter.com/yiifeed') ?> |
                <?= Html::a('About', ['/site/about']) ?>
            </p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
  
  
  <?php GoogleAnalytics::track('UA-96093853-1') ?>
  
  <?php $this->endBody() ?>
  </body>
  </html>
  <?php $this->endPage() ?>