<?php

use yii\db\Migration;

class m161216_142903_create_table_tag extends Migration
{
	const TABLE_NAME = "tag";
    public function up()
    {
		$this->createTable(self::TABLE_NAME,[
			'id'    => $this->primaryKey(),
			'name'  => $this->string(20),
			'color' => $this->string(20)
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
