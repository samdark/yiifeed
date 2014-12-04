<?php

namespace app\modules\auth\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property integer $superuser
 * @property integer $blocked_at
 * @property integer $last_visit_at
 * @property integer $created_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'first_name', 'last_name', 'auth_key', 'superuser', 'last_visit_at', 'created_at'], 'required'],
            [['superuser', 'blocked_at', 'last_visit_at', 'created_at'], 'integer'],
            [['username'], 'string', 'max' => 25],
            [['email', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('auth', 'ID'),
            'username' => Yii::t('auth', 'Username'),
            'email' => Yii::t('auth', 'Email'),
            'password' => Yii::t('auth', 'Password'),
            'first_name' => Yii::t('auth', 'First Name'),
            'last_name' => Yii::t('auth', 'Last Name'),
            'auth_key' => Yii::t('auth', 'Auth Key'),
            'superuser' => Yii::t('auth', 'Superuser'),
            'blocked_at' => Yii::t('auth', 'Blocked At'),
            'last_visit_at' => Yii::t('auth', 'Last Visit At'),
            'created_at' => Yii::t('auth', 'Created At'),
        ];
    }
}
