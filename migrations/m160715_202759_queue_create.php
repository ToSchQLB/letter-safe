<?php

use yii\db\Migration;

class m160715_202759_queue_create extends Migration
{
    var $tablename = "queue";

    public function up()
    {
        $this->createTable(
            $this->tablename,
            [
                'id'    => $this->primaryKey(),
                'time'  => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'job'   => $this->string(512)->notNull()
            ]
        );
    }

    public function down()
    {
        $this->dropTable($this->tablename);
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
