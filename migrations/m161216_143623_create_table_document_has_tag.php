<?php

use yii\db\Migration;

class m161216_143623_create_table_document_has_tag extends Migration
{
	const TABLE_NAME        = "document_has_tag";
	const TABLE_DOCUMENT    = "document";
	const TABLE_TAG         = "tag";
    public function up()
    {
		$this->createTable(self::TABLE_NAME,[
			'document_id'  => $this->integer(),
			'tag_id'       => $this->integer()
		]);
	    $this->addPrimaryKey('pk_document_has_tag',self::TABLE_NAME,['document_id','tag_id']);
		$this->addForeignKey('fk_document_document_has_tag',self::TABLE_NAME,'document_id',self::TABLE_DOCUMENT,'id','CASCADE','CASCADE');
	    $this->addForeignKey('fk_tag_document_has_tag',self::TABLE_NAME,'tag_id',self::TABLE_TAG,'id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_document_document_has_tag',self::TABLE_NAME);
        $this->dropForeignKey('fk_tag_document_has_tag',self::TABLE_NAME);
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
