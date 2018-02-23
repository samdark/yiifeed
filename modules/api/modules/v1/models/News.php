<?php

namespace app\modules\api\modules\v1\models;

use app\components\UserPermissions;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class News extends \app\models\News implements Linkable
{
    public function fields()
    {
        return [
            'id' => 'id',
            'title' => 'title',
            'text' => 'text',
            'link' => 'link',
            'createdAt' => 'created_at',
            'status' => 'status',
            'siteUrl' => function (News $news) {
                return Url::to($news->getUrl(), true);
            }
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return [
            'user' => function (News $news) {
                $user = $news->user;
                if (UserPermissions::canEditUser($user) || (int) $user->status === User::STATUS_ACTIVE) {
                    return $user;
                }
                
                return null;
            }
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['news/view', 'id' => $this->id], true),
            'user' => Url::to(['user/view', 'id' => $this->user_id], true),
        ];
    }
    
}
