<?php

use yii\db\Migration;

class m161218_204942_create_table_document_type_fild extends Migration
{
    const TABLE_NAME = "document_field";
    public function up()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
        ]);
    }

    public function down()
    {
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
