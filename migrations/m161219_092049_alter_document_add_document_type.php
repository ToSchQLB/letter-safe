<?php

use yii\db\Migration;

class m161219_092049_alter_document_add_document_type extends Migration
{
	const TABLE_NAME = "document";
    public function up()
    {
		$this->addColumn(self::TABLE_NAME,'document_type_id',$this->integer());
	    $this->addForeignKey('fk_document_document_type',self::TABLE_NAME,'document_type_id','document_type','id','RESTRICT','CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_document_document_type',self::TABLE_NAME);
	    $this->dropColumn(self::TABLE_NAME,'document_type_id');
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
