<?php

use yii\db\Migration;

class m161230_231246_alter_sender_add_short extends Migration
{
    public function up()
    {
        $this->addColumn('sender','short_name',$this->string(25).' DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('sender','short_name');
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
