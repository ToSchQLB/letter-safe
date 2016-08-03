<?php

use yii\db\Migration;

class m160803_163140_document_alter_1 extends Migration
{
    var $name = 'document';
    public function up(){
        $this->addColumn($this->name,'status', 'tinyint unsigned DEFAULT 0');
    }

    public function down()
    {
        echo "m160803_163140_document_alter_1 cannot be reverted.\n";

        return false;
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
