<?php

namespace app\modules\api\modules\v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class User extends \app\models\User implements Linkable
{
    public function fields()
    {
        return [
            'id' => 'id',
            'username' => 'username',
            'status' => 'status',
            'siteUrl' => function (User $user) {
                return Url::to(['/user/view', 'id' => $user->id], true);
            }
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
            'news' => Url::to(['news/index', 'userId' => $this->id], true),
        ];
    }
    
}
