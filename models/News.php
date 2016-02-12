<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $link
 * @property integer $status
 * @property integer $created_at
 * @property integer $user_id
 *
 * @property User $user
 * @property Comment[] $comments
 */
class News extends ActiveRecord
{
    const STATUS_PROPOSED = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_REJECTED = 3;

    const SCENARIO_SUGGEST = 'suggest';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                //'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => false,
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SUGGEST] = ['title', 'text', 'link'];
        $scenarios[self::SCENARIO_UPDATE] = ['title', 'text', 'link', 'status'];
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'status'], 'required'],
            ['text', 'string'],
            ['status', 'default', 'value' => self::STATUS_PROPOSED],
            ['status', 'integer'],
            ['status', 'filter', 'filter' => 'intval'],
            ['title', 'string', 'max' => 250],
            ['link', 'string', 'max' => 250],
            ['link', 'url', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('news', 'ID'),
            'title' => Yii::t('news', 'Title'),
            'text' => Yii::t('news', 'Text'),
            'link' => Yii::t('news', 'Link'),
            'status' => Yii::t('news', 'Status'),
            'created_at' => Yii::t('news', 'Created At'),
        ];
    }

    public function getStatusLabel()
    {
        return static::statusLabel($this->status);
    }

    public static function statusLabel($status)
    {
        $statuses = static::getStatuses();
        return ArrayHelper::getValue($statuses, $status);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PROPOSED => Yii::t('news', 'Proposed'),
            self::STATUS_PUBLISHED => Yii::t('news', 'Published'),
            self::STATUS_REJECTED => Yii::t('news', 'Rejected'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['news_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // when publishing time should be updated
            if ($this->status === self::STATUS_PUBLISHED && $this->getOldAttribute('status') !== self::STATUS_PUBLISHED) {
               $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
