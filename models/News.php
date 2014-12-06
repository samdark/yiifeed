<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

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
class News extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLIC = 2;
    const STATUS_DELETE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

     public function behaviors()
     {
         return [
             [
                 'class' => TimestampBehavior::className(),
                 //'createdAtAttribute' => 'create_time',
                 'updatedAtAttribute' => FALSE,
             ],
         ];
     }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['user_insert'] = ['title', 'text','link'];
        $scenarios['insert'] = ['title', 'text','link','status'];
        $scenarios['update'] = ['title', 'text','link','status'];
        //$scenarios['register'] = ['username', 'email', 'password'];
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
            [['status'], 'integer'],
          //  [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['link'], 'string', 'max' => 200],
            [['link'], 'url','skipOnEmpty' => true],
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

    public function getStatus($id = null)
    {
       if(!intval($id)) return FALSE;
       $Statuses = $this->getStatusesArray();
       if(array_key_exists($id,$Statuses)) return $Statuses[$id];
       else return FALSE;
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_DRAFT => Yii::t('news', 'Draft'),
            self::STATUS_PUBLIC => Yii::t('news', 'Public'),
            self::STATUS_DELETE => Yii::t('news', 'Delete'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            //@todo After create auth module Change statuses
            if($this->getScenario() == 'user_insert'){
            // If user is logged in as admin
            $this->status = News::STATUS_PUBLIC;
            //If user is logged
            // $insert->status = News::STATUS_DRAFT;
            }

           // $this->created_at = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }

    }

}
