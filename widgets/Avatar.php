<?php
namespace app\widgets;

use app\models\User;
use cebe\gravatar\Gravatar;
use yii\base\Widget;

/**
 * Renders user avatar
 */
class Avatar extends Widget
{
    /**
     * @var User
     */
    public $user;
    public $size = 32;
    public $options = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        return Gravatar::widget([
            'defaultImage' => 'identicon',
            'email' => $this->user->email ? $this->user->email : $this->user->username,
            'options' => [
                'alt' => $this->user->username,
                'width' => $this->size,
                'height' => $this->size,
            ],
            'size' => $this->size,
        ]);
    }
}
