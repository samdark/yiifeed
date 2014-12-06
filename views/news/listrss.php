<?php
use yii\helpers\Markdown;
/* @var $this yii\web\View */ ?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<rss version="2.0">
    <channel>
        <title>Yiifeed News</title>
        <link><?=yii\helpers\Url::base(true)?></link>
        <description>Last news from Yiifeed</description>
        <?php foreach($news as $item){ ?>
            <item>
                <title><?=\yii\helpers\Html::encode($item->title)?></title>
                <description><?=strip_tags(Markdown::process($item->text))?></description>
                <pubDate><?=date("D, j M Y G:i:s", $item->created_at). " GMT"?></pubDate>
            </item>
        <? }?>
    </channel>
</rss>