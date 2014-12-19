<?php

use yii\db\Schema;
use yii\db\Migration;

class m141219_152350_add_field_to_news_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news}}','user_id','int');
        $this->addForeignKey('fk-news-user_id-user-id', '{{%news}}', 'user_id', '{{%user}}', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk-news-user_id-user-id','{{%news}}');
        $this->dropColumn('{{%news}}','user_id');
    }
}
