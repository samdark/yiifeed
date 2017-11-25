<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * @see User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * @return $this
     */
    public function sortByDefault()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }
    
}
