<?php

use yii\db\Schema;
use yii\db\Migration;

class m141202_220415_create_news_table extends Migration
{
    protected  $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    protected $tableName = '{{%news}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(50) NOT NULL',
            'text' => Schema::TYPE_TEXT . '(6000) NOT NULL',
            'link' => Schema::TYPE_STRING . '(255) NULL',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . '(255) NOT NULL',
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
