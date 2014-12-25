<?php

use yii\db\Schema;
use yii\db\Migration;

class m141225_135710_adjust_news_title_length extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%news}}', 'title', Schema::TYPE_STRING . ' NOT NULL');
    }

    public function down()
    {
        $this->alterColumn('{{%news}}', 'title', Schema::TYPE_STRING . '(50) NOT NULL');
    }
}
