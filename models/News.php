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
 * @property string $created_at
 */
class News extends ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLIC = 2;
    const STATUS_DELETED = 3;

    const SCENARIO_SUGGEST = 'suggest';

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
        $scenarios['insert'] = ['title', 'text', 'link', 'status'];
        $scenarios['update'] = ['title', 'text', 'link', 'status'];
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'status'], 'required'],
            [['text'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['link'], 'string', 'max' => 200],
            [['link'], 'url', 'skipOnEmpty' => true],
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
        $statuses = $this->getStatuses();
        return ArrayHelper::getValue($statuses, $this->status);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => Yii::t('news', 'Draft'),
            self::STATUS_PUBLIC => Yii::t('news', 'Public'),
            self::STATUS_DELETED => Yii::t('news', 'Deleted'),
        ];
    }
}
