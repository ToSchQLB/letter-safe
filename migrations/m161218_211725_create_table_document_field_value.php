<?php

use yii\db\Migration;

class m161218_211725_create_table_document_field_value extends Migration
{
    const TABLE_NAME = 'document_value';
    public function up()
    {
        $this->createTable(self::TABLE_NAME,[
            'document_id'=>$this->integer(),
            'field_id'=>$this->integer(),
            'value'=>$this->string(100)
        ]);
        $this->addPrimaryKey(
            'pk_document_value',
            self::TABLE_NAME,
            [
                'document_id',
                'field_id'
        ]);

        $this->addForeignKey(
            'fk_document_document_value',
            self::TABLE_NAME,
            'document_id',
            'document',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_field_document_value',
            self::TABLE_NAME,
            'field_id',
            'document_field',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_field_document_value',
            self::TABLE_NAME
        );
        $this->dropForeignKey(
            'fk_document_document_value',
            self::TABLE_NAME
        );
        $this->dropTable(self::TABLE_NAME);
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
