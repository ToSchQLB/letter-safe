<?php

use yii\db\Migration;

class m161214_192346_create_tag extends Migration
{
    const TAB_NAME = "tag";
    public function up()
    {
        $this->createTable(self::TAB_NAME,[
            'id'    => $this->primaryKey(),
            'name'  => $this->string(45)
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TAB_NAME);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
