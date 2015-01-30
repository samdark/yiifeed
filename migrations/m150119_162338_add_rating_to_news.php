<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_162338_add_rating_to_news extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news}}', 'rating', 'smallint NOT NULL');
        $this->addColumn('{{%news}}', 'aggregate_rating', 'float unsigned NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%news}}', 'rating');
        $this->dropColumn('{{%news}}', 'aggregate_rating');
    }
}
