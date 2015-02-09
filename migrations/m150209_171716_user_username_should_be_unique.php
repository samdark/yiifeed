<?php

use yii\db\Schema;
use yii\db\Migration;

class m150209_171716_user_username_should_be_unique extends Migration
{
    public function up()
    {
        $this->createIndex('idx-user-username-unique', '{{%user}}', 'username', true);
        $this->createIndex('idx-user-email-unique', '{{%user}}', 'email', true);
    }

    public function down()
    {
        $this->dropIndex('idx-user-username-unique', '{{%user}}');
        $this->dropIndex('idx-user-email-unique', '{{%user}}');
    }
}
