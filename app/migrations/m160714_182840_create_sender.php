<?php

use yii\db\Migration;

class m160714_182840_create_sender extends Migration
{
    var $name = 'sender';

    public function up()
    {
        $this->createTable(
            $this->name,
            [
                'id'        => $this->primaryKey(),
                'name'      => $this->string(255),
                'adress1'   => $this->string(255),
                'adress2'   => $this->string(255),
                'zip'       => $this->string(5),
                'town'      => $this->string(255),
                'state'     => $this->string(100),
                'country'   => $this->string(100)
            ]
        );
    }

    public function down()
    {
        $this->dropTable($this->name);
        return true;
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
