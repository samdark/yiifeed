<?php
namespace app\notifier;

use Yii;

class Notifier
{
    private $notification;

    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function sendEmails()
    {
        $to = $this->notification->getToUser();

        if (!$to || empty($to->email)) {
            // can't send emails
            return false;
        }

        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['notificationEmail'])
            ->setTo($to->email)
            ->setSubject($this->notification->getSubject())
            ->setTextBody($this->notification->getText())
            ->send();
    }
}