<?php

namespace app\models;

use app\components\queue\NewsShareJob;
use Yii;
use yii\behaviors\SluggableBehavior;
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
 * @property bool $published_to_twitter
 * @property string $slug
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
    const SCENARIO_ADMIN = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SUGGEST] = ['title', 'text', 'link'];
        $scenarios[self::SCENARIO_UPDATE] = ['title', 'text', 'link'];
        $scenarios[self::SCENARIO_ADMIN] = ['title', 'text', 'link', 'status'];
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
            ['published_to_twitter', 'boolean'],

            ['slug', 'required'],
            ['slug', 'string', 'max' => 255],
            ['slug', 'trim'],
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
            'slug' => Yii::t('news', 'Slug'),
        ];
    }

    /**
     * @return string status as string
     */
    public function getStatusLabel()
    {
        return static::statusLabel($this->status);
    }

    /**
     * Returns a string representation of status
     *
     * @param int $status
     * @return string
     */
    public static function statusLabel($status)
    {
        $statuses = static::getStatuses();
        return ArrayHelper::getValue($statuses, $status);
    }

    /**
     * @return array statuses available
     */
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
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // when publishing time should be updated
        if ($this->status === self::STATUS_PUBLISHED && $this->getOldAttribute('status') !== self::STATUS_PUBLISHED) {
           $this->created_at = time();
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (array_key_exists('status', $changedAttributes) && $changedAttributes['status'] != $this->status && (int) $this->status === self::STATUS_PUBLISHED) {
            $this->addShareJob();
        }
    }

    /**
     * Add a task to share news.
     *
     * @return bool
     */
    public function addShareJob()
    {
        if ((int) $this->status === self::STATUS_PUBLISHED && !$this->published_to_twitter) {
            Yii::$app->queue->push(new NewsShareJob([
                'newsId' => $this->id
            ]));
            
            return true;
        }
        
        return false;
    }

    /**
     * @inheritdoc
     *
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Comment::deleteAll(['news_id' => $this->id]);
            
            return true;
        }
        
        return false;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getUrl($params = [])
    {
        return array_merge(['/news/view', 'id' => $this->id, 'slug' => $this->slug], $params);
    }
    
}
