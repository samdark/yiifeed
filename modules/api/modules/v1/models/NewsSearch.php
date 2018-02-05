<?php

namespace app\modules\api\modules\v1\models;

use app\components\UserPermissions;
use app\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

/**
 * @property User $user
 * @property bool $canAdminNews
 */
class NewsSearch extends Model
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $link;
    /**
     * @var int
     */
    public $status;
    /**
     * @var int
     */
    public $userId;

    /**
     * @var User
     */
    private $_user;
    /**
     * @var bool
     */
    private $_canAdminNews = false;

    public function __construct(User $user, $canAdminNews = false, array $config = [])
    {
        $this->_user = $user;
        $this->_canAdminNews = $canAdminNews;
        
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'status'], 'integer'],
            [['title', 'text', 'link'], 'string'],
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     * @throws BadRequestHttpException
     */
    public function search($params)
    {
        $query = News::find()->sortByDefault();
        
        if (!$this->canAdminNews) {
            $query->andWhere([
                'or',
                ['status' => News::STATUS_PUBLISHED],
                ['user_id' => $this->user->id]
            ]);
        }
        
        $this->load($params);

        if (!$this->validate()) {
            throw new BadRequestHttpException('Invalid parameters: ' . json_encode($this->getErrors()));
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->userId,
            'status' => $this->status,
        ])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'link', $this->link]);
        
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @return bool
     */
    public function getCanAdminNews()
    {
        return $this->_canAdminNews;
    }

}
