<?php

use yii\db\Migration;

/**
 * Class m190319_184010_fill_regex_data
 */
class m190319_184010_fill_regex_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(
            'document_type', [
                'regex' => '(rechnung|barverkauf)'
            ], [
                'name' => 'Rechnung'
            ]
        );

        $this->update(
            'document_type', [
                'regex' => '(kontoauszug|kreditkartenabrechnung )'
            ], [
                'name' => 'Kontoauszug'
            ]
        );
        $this->update(
            'document_type', [
                'regex' => '(versicherung)'
            ],[
                'name' => 'Versicherung'
            ]
        );

        $this->update(
            'document_field', [
                'regex'  => '(gesamt|brutto|end| )(betrag|summe)[ :,a-z]*([\d,.]+)[\W]{0,1}[e,€â]{0,1}',
                'element'=> '3'
            ],[
                'name' => 'Rechnungsbetrag'
            ]
        );

        $this->update(
            'document_field', [
            'regex'  => '(rechnung|beleg|be1eg)(nr|nummer|s-nr|snummer)[\W\s]*([\w-\/]*)',
            'element'=> '3'
        ],[
                'name' => 'Rechnungsnummer'
            ]
        );

        $this->update(
            'document_field', [
            'regex'  => '(kd|kunden|mitglied)(s-nr|snummer|-nr|nummer)[\W\s]*([\w-\/]*)',
            'element'=> '3'
        ],[
                'name' => 'Kundennummer'
            ]
        );

        $this->update(
            'document_field', [
            'regex'  => 'auftrag(s-nr|snummer)[\W\s]*([\w-\/]*)',
            'element'=> '2'
        ],[
                'name' => 'Auftragsnummer'
            ]
        );

        $this->update(
            'document_field', [
            'regex'  => '(versicherung)(nr| nr|nummer|s-nr|snummer)[\W\s]*([\w-\/]*)',
            'element'=> '3'
        ],[
                'name' => 'Versicherungsnummer'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190319_184010_fill_regex_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190319_184010_fill_regex_data cannot be reverted.\n";

        return false;
    }
    */
}
