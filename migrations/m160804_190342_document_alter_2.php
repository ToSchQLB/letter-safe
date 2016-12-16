<?php

use yii\db\Migration;

class m160804_190342_document_alter_2 extends Migration
{
    var $name = 'document';
    public function up()
    {
        $this->addColumn($this->name,'input_filename',$this->string(255));
        $this->addColumn($this->name,'input_date',$this->dateTime());
        $this->addColumn($this->name,'input_file_extension',$this->string(255));
    }

    public function down()
    {
        $this->dropColumn($this->name,'input_filename');
        $this->dropColumn($this->name,'input_date');
        $this->dropColumn($this->name,'input_file_extension');
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
