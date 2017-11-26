<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $github
 * @property string $access_token
 *
 * @property Auth[] $auths
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_ACCESS_TOKEN = 'accessToken';
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['status', 'filter', 'filter' => 'intval'],
            
            ['access_token', 'string', 'length' => 64],
            ['access_token', 'default'],
            ['access_token', 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        
        ArrayHelper::removeValue($scenarios[self::SCENARIO_DEFAULT], 'access_token');
        $scenarios[self::SCENARIO_ACCESS_TOKEN] = ['access_token'];
        
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = (string) $token;
        if ($token !== '') {
            return static::find()->andWhere(['access_token' => $token])->active()->one();
        }
        
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString(64);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'E-mail'),
            'status' => Yii::t('user', 'Status'),
            'created_at' => Yii::t('user', 'Created At'),
        ];
    }

    public function getStatusLabel()
    {
        $statuses = self::getStatuses();
        return ArrayHelper::getValue($statuses, $this->status);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DELETED => Yii::t('user', 'Delete'),
            self::STATUS_ACTIVE  => Yii::t('user', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return string GitHub profile URL or null if user isn't connected with GitHub
     */
    public function getGithubProfileUrl()
    {
        return $this->github ? 'http://github.com/' . $this->github : null;
    }

    /**
     * @inheritdoc
     *
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
