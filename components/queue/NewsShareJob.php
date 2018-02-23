<?php

namespace app\components\queue;

use Abraham\TwitterOAuth\TwitterOAuth;
use app\models\News;
use Yii;
use yii\base\BaseObject;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\queue\JobInterface;
use yii\queue\RetryableJobInterface;

class NewsShareJob extends BaseObject implements JobInterface, RetryableJobInterface
{
    /**
     * @var int
     */
    public $newsId;

    public function execute($queue)
    {
        /** @var News $news */
        $news = News::find()
            ->andWhere([
                'id' => $this->newsId,
                'status' => News::STATUS_PUBLISHED,
                'published_to_twitter' => false
            ])
            ->limit(1)
            ->one();
        
        if (!$news) {
            return;
        }

        $params = Yii::$app->params;

        $twitter = new TwitterOAuth(
            $params['twitter.consumerKey'],
            $params['twitter.consumerSecret'],
            $params['twitter.accessToken'],
            $params['twitter.accessTokenSecret']
        );

        $newsUrl = Url::to($news->getUrl(), true);

        // The maximum message length is 140 characters. For URL you need 23 characters.
        $message = StringHelper::truncate($news->title, 108) . " {$newsUrl} #yii";
        $twitter->post('statuses/update', ['status' => $message]);
        
        try {
            $status = (int) $twitter->getLastHttpCode();
            if ($status === 200) {
                $news->published_to_twitter = true;
                if (!$news->save()) {
                    throw new JobException("Failed marking news {$news->id} as published_to_twitter.");
                }
            } else {
                throw new JobException("Tweeting failed with status {$status}:\n" . var_export($twitter->getLastBody(), true));
            }
        } catch (JobException $ex) {
            Yii::error($ex->getMessage());
            throw new $ex;
        }
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 300;
    }

    /**
     * @param int $attempt
     * @param \Exception $error
     *
     * @return bool
     */
    public function canRetry($attempt, $error)
    {
        return ($attempt < 3) && ($error instanceof JobException);
    }
}
