<?php

use yii\db\Schema;
use yii\db\Migration;
use app\modules\auth\helpers\Password;

class m141201_180451_create_users_table extends Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    public $tableName = '';

    public function init()
    {
        parent::init();
        $this->tableName = \Yii::$app->getModule('auth')->tableMap['User'];
    }

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . '(25) NOT NULL',
            'email' => Schema::TYPE_STRING . '(255) NOT NULL',
            'password' => Schema::TYPE_STRING . '(60) NOT NULL',
            'first_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'last_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'superuser' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'blocked_at' => Schema::TYPE_INTEGER,
            'last_visit_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);


        $this->insert($this->tableName,[
            'username'=>'admin',
            'email'=>'admin',
            'password'=>Password::hash('admin1'),
            'first_name'=>'Admin',
            'last_name'=>'istrator',
            'superuser'=>1,
            'blocked_at'=>0,
            'created_at'=>time(),
        ]);


    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
