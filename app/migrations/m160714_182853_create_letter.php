<?php

use yii\db\Migration;

class m160714_182853_create_letter extends Migration
{
    var $name = 'letter';
    public function up()
    {
        $this->createTable(
            $this->name,
            [
                'id'        => $this->primaryKey(),
                'sender_id' => $this->integer(),
                'title'     => $this->string(255),
                'message'   => 'longtext',
                'folder'    => $this->string(100)
            ]
        );
        $this->addForeignKey(
            'fk_letter_sender',
            $this->name,
            'sender_id',
            'sender',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_letter_sender',
            $this->name
        );
        $this->dropTable(
            $this->name
        );
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
