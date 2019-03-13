<?php

use yii\db\Migration;

/**
 * Handles adding rg to table `document`.
 */
class m190313_171312_add_rg_column_to_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('document_type', 'regex', $this->string(1024));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('document_type', 'regex');
    }
}
