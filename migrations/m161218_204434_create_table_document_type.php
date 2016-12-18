<?php

use yii\db\Migration;

class m161218_204434_create_table_document_type extends Migration
{
    const TABLE_NAME = "document_type";

    public function up()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'name' => $this->string(),
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
