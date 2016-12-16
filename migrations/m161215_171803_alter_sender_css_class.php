<?php

use yii\db\Migration;

class m161215_171803_alter_sender_css_class extends Migration
{
    const TABLE_NAME = 'sender';

    public function up()
    {
        $this->addColumn(self::TABLE_NAME,'css_class',$this->string(20));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'css_class');
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
