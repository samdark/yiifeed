<?php


namespace app\components;


use app\models\News;
use app\models\User;

/**
 * UserPermissions contains various methods to check what user can do
 */
class UserPermissions
{
    const ADMIN_NEWS = 'adminNews';
    const ADMIN_USERS = 'adminUsers';

    /**
     * Checks if user can admin news
     * @return bool
     */
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

    /**
     * Checks if user can edit particular news
     * @param News $news
     * @return bool
     */
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

    /**
     * Checks if user can admin other users
     * @return bool
     */
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

    /**
     * Checks if user can edit profile
     * @param User $user
     * @return bool
     */
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
