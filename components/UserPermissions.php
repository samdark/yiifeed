<?php

namespace app\components;

use app\models\Comment;
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
        
        if ((int) $user->id === (int) \Yii::$app->user->getId() && (int) $user->status === User::STATUS_ACTIVE) {
            return true;
        }
        
        if (self::canAdminUsers()) {
            return true;
        }

        return false;
    }
    
    /**
     * @param Comment $comment
     *
     * @return bool
     */
    public static function canManageComment(Comment $comment)
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (self::canAdminNews()) {
            return true;
        }

        $currentUserID = (int) \Yii::$app->user->getId();
        if ((int) $comment->user_id === $currentUserID || (int) $comment->news->user_id === $currentUserID) {
            return true;
        }

        return false;
    }
    
}
