<?php


namespace app\notifier;


use app\models\Comment;
use app\models\User;
use yii\helpers\Url;

class NewCommentNotification implements NotificationInterface
{
    private $comment;
    private $user;

    /**
     * NewCommentNotification constructor.
     * @param Comment $comment
     * @param User $user
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getToUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'There is a new comment at YiiFeed';
    }

    /**
     * @return string
     */
    public function getText()
    {
        $link = Url::to($this->comment->news->getUrl(['#' => 'c' . $this->comment->id]), true);
        return <<<TEXT
Hi!

There is a new comment at YiiFeed waiting for you:

$link
TEXT;
    }
}
