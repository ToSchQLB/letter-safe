<?php

use yii\db\Migration;

/**
 * Handles adding rg to table `document_type_has_field`.
 */
class m190313_171752_add_rg_column_to_document_type_has_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('document_type_has_field', 'required', $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('document_type_has_field', 'required');
    }
}
