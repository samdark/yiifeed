<?php

use yii\db\Migration;
use yii\helpers\Inflector;

/**
 * Class m180223_074852_add_slug_to_news
 */
class m180223_074852_add_slug_to_news extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'slug', $this->string()->notNull()->defaultValue(''));
        
        $allNews = $this->db->createCommand("SELECT id, title FROM {{%news}}")->queryAll();
        foreach ($allNews as $news) {
            $this->update('{{%news}}', ['slug' => Inflector::slug($news['title'])], ['id' => $news['id']]);
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{%news}}', 'slug');
    }
    
}
