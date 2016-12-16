<?php

use yii\db\Migration;

class m161214_192346_add_sender_logo extends Migration
{
    const TAB_NAME = "sender";
    public function up()
    {
        $this->addColumn(self::TAB_NAME,[
            'logo' => $this->string(255)
        ]);
    }

    public function down()
    {
        $this->renameColumn(self::TAB_NAME,'logo');
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
