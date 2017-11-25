<?php

use yii\db\Migration;

class m171125_114314_create_access_token_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string(64)->null());
        $this->createIndex('idx-user-access_token-unique', '{{%user}}', 'access_token', true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user-access_token-unique', '{{%user}}');
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
