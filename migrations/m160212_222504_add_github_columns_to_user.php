<?php

use yii\db\Schema;
use yii\db\Migration;

class m160212_222504_add_github_columns_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'github', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'github');
    }
}
