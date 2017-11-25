<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * @see News
 */
class NewsQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function published()
    {
        return $this->andWhere(['status' => News::STATUS_PUBLISHED]);
    }

    /**
     * @return $this
     */
    public function sortByDefault()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }
    
}
