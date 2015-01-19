<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_152257_change_user_email_to_nullable extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'email', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'email', Schema::TYPE_STRING . ' NOT NULL');
    }
}
