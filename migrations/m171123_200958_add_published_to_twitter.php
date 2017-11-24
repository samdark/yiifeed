<?php

use yii\db\Migration;

class m171123_200958_add_published_to_twitter extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'published_to_twitter', $this->boolean()->defaultValue(false)->notNull());
        
        $this->update('{{%news}}', ['published_to_twitter' => true]);
        
        $this->createIndex('idx-news-status-published_to_twitter', '{{%news}}', ['status', 'published_to_twitter']);
    }

    public function safeDown()
    {
        $this->dropIndex('idx-news-status-published_to_twitter', '{{%news}}');
        $this->dropColumn('{{%news}}', 'published_to_twitter');
    }   
}
