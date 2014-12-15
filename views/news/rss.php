<?php
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<rss version="2.0">
    <channel>
        <title>Yiifeed News</title>
        <link><?= Url::base(true) ?></link>
        <description>Last news from YiiFeed</description>
        <?php foreach ($news as $item): ?>
            <item>
                <title><?= Html::encode($item->title) ?></title>
                <description><?= strip_tags(Markdown::process($item->text)) ?></description>
                <pubDate><?= date("D, j M Y G:i:s", $item->created_at). " GMT" ?></pubDate>
            </item>
        <?php endforeach ?>
    </channel>
</rss>