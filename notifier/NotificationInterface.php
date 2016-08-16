<?php


namespace app\notifier;


use app\models\User;

interface NotificationInterface
{
    /**
     * @return User
     */
    public function getToUser();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getText();
}
