<?php
/**
 * @var $model app\models\News
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;
use \yii\helpers\HtmlPurifier;

/* @var yii\web\View $this */

$isFull = isset($isFull) ? $isFull : false;
$displayStatus = isset($displayStatus) ? $displayStatus : false;
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

<div class="row">
    <div class="col-md-2 col-sm-3 post-meta">
        <p class="time">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?= Yii::$app->formatter->asDate($model->created_at) ?>
        </p>

        <?php if ($displayStatus): ?>
        <p><?= Yii::t('news', 'Status') .": ". $model->getStatusLabel() ?></p>
        <?php endif ?>

        <?php if ($displayModeratorButtons): ?>
            <?= Html::a(Yii::t('news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('news', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </div>
    <div class="col-sm-9 col-md-10 post">
        <h1>
            <?= $isFull ? Html::encode($model->title) : Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?>
        </h1>

        <div class="content">
            <?php
            $text = HtmlPurifier::process(Markdown::process($model->text));
            echo $isFull ? $text : StringHelper::truncateWords($text, 70, '<p>' . Html::a('Read more', ['view', 'id' => $model->id]) . '</p>', true);
            ?>

            <?php if ($isFull): ?>
            <div class="meta">
                <?php if (!empty($model->link)): ?>
                    <p><?= Html::a(Html::encode($model->link), $model->link) ?></p>
                <?php endif ?>

                <?php echo \chiliec\vote\Display::widget([
                    'model_name' => 'news',
                    'target_id' => $model->id,
                ]); ?>

                <a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-hashtags="yii" data-url="<?= Url::canonical() ?>" data-text="<?= Html::encode($model->title) ?>">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

                <div class="fb-share-button" data-href="<?= Url::canonical() ?>" data-layout="button"></div>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>