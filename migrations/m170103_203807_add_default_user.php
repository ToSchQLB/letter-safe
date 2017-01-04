<?php

use yii\db\Migration;

class m170103_203807_add_default_user extends Migration
{
    public function up()
    {
        $user = new \app\models\User();
        $user->username = "admin";
        $user->password = "admin";
	    $user->email = "admin@local";
        $user->save();
    }

    public function down()
    {
        $user = \app\models\User::findOne(['username'=>'admin']);
	    if(!is_null($user)){
		    $user->delete();
	    }
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
