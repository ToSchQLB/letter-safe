<?php

use yii\db\Migration;

class m161218_205900_create_table_document_type__has_field extends Migration
{
    const TABLE_NAME = "document_type_has_field";

    public function up()
    {
        $this->createTable(self::TABLE_NAME,[
            'document_type_id' => $this->integer(),
            'field_id' => $this->integer(),
        ]);
        $this->addPrimaryKey(
            'pk_document_type_has_field',
            self::TABLE_NAME,
            [
                'document_type_id',
                'field_id'
            ]);
        $this->addForeignKey(
            'fk_document_type_document_type_has_field',
            self::TABLE_NAME,
            'document_type_id',
            'document_type',
            'id',
            'CASCADE','CASCADE'
        );
        $this->addForeignKey(
            'fk_field_document_type_has_field',
            self::TABLE_NAME,
            'field_id',
            'document_field',
            'id',
            'CASCADE','CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_field_document_type_has_field',
            self::TABLE_NAME
        );
        $this->dropForeignKey(
            'fk_document_type_document_type_has_field',
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
