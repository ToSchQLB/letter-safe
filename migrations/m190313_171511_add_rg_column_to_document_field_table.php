<?php

use yii\db\Migration;

/**
 * Handles adding rg to table `document_field`.
 */
class m190313_171511_add_rg_column_to_document_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('document_field', 'regex', $this->string(1024));
        $this->addColumn('document_field', 'element', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('document_field', 'regex');
        $this->dropColumn('document_field', 'element');
    }
}
