<?php

use yii\db\Migration;

class m161230_235324_alter_sender_add_name_2 extends Migration
{
    public function up()
    {
        $this->addColumn('sender','name_2',$this->string(255).' DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('sender','name_2');
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
