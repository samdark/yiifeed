<?php
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>YiiFeed News</title>
        <link><?= Url::base(true) ?></link>
        <atom:link rel="self" href="<?= Url::to([''], true) ?>" />
        <description>Everything about Yii framework</description>
        <language>en</language>
        <?php foreach ($news as $item): ?>
            <item>
                <title><?= Html::encode($item->title) ?></title>
                <description><![CDATA[<?= Html::encode(Markdown::process($item->text)) ?>]]></description>
                <guid isPermaLink="false"><![CDATA[<?= Url::to(['news/view', 'id' => $item->id], true)?>]]></guid>
                <pubDate><?= date("D, j M Y G:i:s", $item->created_at). " GMT" ?></pubDate>
            </item>
        <?php endforeach ?>
    </channel>
</rss>