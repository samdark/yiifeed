<?php

namespace app\helpers;

use yii\web\View;

/**
 * GoogleAnalytics adds tracking code to the page if application is not in debug mode
 */
class GoogleAnalytics
{
    /**
     * Adds trackign code with tracking ID specified to the page
     *
     * @param string $id
     */
    public static function track($id)
    {
        if (YII_DEBUG) {
            return;
        }

        $js = <<<JS
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', '$id', 'auto');
ga('send', 'pageview');
JS;
        \Yii::$app->getView()->registerJs($js, View::POS_END);
    }
}
