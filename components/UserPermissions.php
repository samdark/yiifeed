<?php


namespace app\components;


use app\models\News;
use app\models\Project;
use app\models\User;

class UserPermissions
{
    const ADMIN_NEWS = 'adminNews';
    const ADMIN_USERS = 'adminUsers';

    public static function canAdminNews()
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_NEWS)) {
            return true;
        }

        return false;
    }

    public static function canEditNews(News $news)
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (self::canAdminNews()) {
            return true;
        }

        $currentUserID = \Yii::$app->user->getId();
        if ((int)$news->user_id === (int)$currentUserID && (int)$news->status === News::STATUS_PROPOSED) {
            return true;
        }

        return false;
    }

    public static function canAdminUsers()
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_USERS)) {
            return true;
        }

        return false;
    }

    public static function canEditUser(User $user)
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        $currentUserID = \Yii::$app->user->getId();

        if ((int)$user->id === $currentUserID) {
            return true;
        }

        if (self::canAdminUsers()) {
            return true;
        }

        return false;
    }
}
