<?php

use yii\db\Migration;

/**
 * Class m190319_120536_update_document_table_1
 */
class m190319_120536_update_document_table_1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('document', 'full_text', 'LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190319_120536_update_document_table_1 cannot be reverted.\n";

        return false;
    }
    */
}
