<?php


namespace app\notifier;


use app\models\News;
use app\models\User;
use yii\helpers\Url;

class NewSuggestionNotification implements NotificationInterface
{
    private $news;

    /**
     * NewSuggestionNotification constructor.
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * @return User
     */
    public function getToUser()
    {
        return User::findByUsername('samdark');
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'New suggestion at YiiFeed!';
    }

    /**
     * @return string
     */
    public function getText()
    {
        $link = Url::to($this->news->getUrl(), true);

        return <<<TEXT
There's a new suggestion at YiiFeed:

$link
TEXT;

    }
}