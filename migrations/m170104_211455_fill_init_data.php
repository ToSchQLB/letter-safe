<?php

use yii\db\Migration;

class m170104_211455_fill_init_data extends Migration
{
    public function up()
    {
        $dtRechnung = new \app\models\DocumentType();
        $dtRechnung->name = "Rechnung";
        $dtRechnung->save();

        $dtVersicherung = new \app\models\DocumentType();
        $dtVersicherung->name = "Versicherung";
        $dtVersicherung->save();

        $df = new \app\models\DocumentField();
        $df->name = "Rechnungsbetrag";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtRechnung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Rechnungsnummer";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtRechnung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Kundennummer";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtRechnung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Auftragsnummer";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtRechnung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Versicherungsnummer";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtVersicherung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Policenummer";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtVersicherung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Versicherungsbeginn";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtVersicherung->id;
        $dthf->field_id = $df->id;
        $dthf->save();

        $df = new \app\models\DocumentField();
        $df->name = "Versicherungsende";
        $df->save();

        $dthf = new \app\models\DocumentTypeHasField();
        $dthf->document_type_id = $dtVersicherung->id;
        $dthf->field_id = $df->id;
        $dthf->save();
    }

    public function down()
    {
        echo "m170104_211455_fill_init_data cannot be reverted.\n";

        return false;
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
