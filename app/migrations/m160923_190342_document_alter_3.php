<?php

use yii\db\Migration;

class m160923_190342_document_alter_3 extends Migration
{
    var $name = 'document';
    public function up()
    {
        $this->addColumn($this->name,'full_text','longtext');
    }

    public function down()
    {
        $this->dropColumn($this->name,'full_text');
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
