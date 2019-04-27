<?php
/* @var $model app\models\News */
/* @var $commentForm app\models\Comment */
use app\components\UserPermissions;
use app\widgets\Avatar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Markdown;
use \yii\helpers\HtmlPurifier;

/* @var yii\web\View $this */

$isFull = isset($isFull) ? $isFull : false;
$displayStatus = isset($displayStatus) ? $displayStatus : false;
$displayUser = isset($displayUser) ? $displayUser : true;
$displayModeratorButtons = isset($displayModeratorButtons) ? $displayModeratorButtons : false;

// OpenGraph metatags
$this->registerMetaTag(['property' => 'og:title', 'content' => Html::encode($model->title)]);
$this->registerMetaTag(['property' => 'og:site_name', 'content' => 'YiiFeed']);
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::canonical()]);

?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=444774969003761&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="row post">
<div class="col-lg-2 col-md-3 col-sm-3 info">
    <p class="time"><?= Yii::$app->formatter->asDate($model->created_at) ?></p>
    <?php if ($displayUser && $model->user_id): ?>
    <p class="author">
    <?= Html::a(Avatar::widget(['user' => $model->user, 'size' => 48]), ['user/view', 'id' => $model->user->id]) ?>
    </p>
    <p class="twitter-handle">
    <?= Html::a('@' . Html::encode($model->user->username), ['user/view', 'id' => $model->user->id]) ?>
    </p>

    <?php endif ?>
    <?php if ($displayStatus): ?>
    <p class="status"><?= Yii::t('news', 'Status') .": ". $model->getStatusLabel() ?></p>
    <?php endif ?>

    <?php if ($displayModeratorButtons): ?>
        <?= Html::a(Yii::t('news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php if (UserPermissions::canAdminNews()): ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    <?php endif ?>
</div>
<div class="col-lg-7 col-md-9 col-sm-9 clearfix">
    <h2><?= $isFull ? Html::encode($model->title) : Html::a(Html::encode($model->title), $model->getUrl()) ?></h2>
    <div class="content">
    <?= HtmlPurifier::process(Markdown::process($model->text, 'gfm'), [
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) ?>

    <?php if ($isFull): ?>
    <div class="meta">
        <?php if (!empty($model->link)): ?>
            <p><?= Html::a(Html::encode($model->link), $model->link) ?></p>
        <?php endif ?>

        <a target="_blank" href="https://twitter.com/intent/tweet?status=<?= urlencode(Html::encode($model->title) . ' ' . Url::canonical() . ' #yii') ?>" class="btn btn-sm btn-twitter"><i class="fa fa-twitter" aria-hidden="true"></i> Tweet</a>
        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Url::canonical() . ', ' . Html::encode($model->title)) ?>" class="btn btn-sm btn-facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Share</a>

    </div>
    <?php endif ?>
</div>
</div>
</div>


<?php if ($isFull): ?>
    <?= $this->render('_comments', [
        'comments' => $model->comments,
        'commentForm' => $commentForm,
    ]) ?>
<?php endif ?>
