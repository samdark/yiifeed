<?php

use yii\db\Schema;
use yii\db\Migration;

class m141205_224547_change_news_date_field_type extends Migration
{

    protected $tableName = '{{%news}}';
    public function up()
    {
        $this->alterColumn($this->tableName,'created_at',Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->alterColumn($this->tableName,'created_at',Schema::TYPE_DATETIME);
    }
}
