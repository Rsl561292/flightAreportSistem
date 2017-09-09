<?php

use yii\db\Migration;
use common\models\RegistrationDesk;

class m170909_113511_alter_tbl_registration_desk_add_columnes extends Migration
{
    public function safeUp()
    {
        $this->addColumn(RegistrationDesk::tableName(), 'created_at', $this->dateTime()->notNull()->after('status'));
        $this->addColumn(RegistrationDesk::tableName(), 'updated_at', $this->dateTime()->notNull()->after('created_at'));
    }

    public function safeDown()
    {
        $this->dropColumn(RegistrationDesk::tableName(),'created_at');
        $this->dropColumn(RegistrationDesk::tableName(),'updated_at');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170909_113511_alter_tbl_registration_desk_add_columnes cannot be reverted.\n";

        return false;
    }
    */
}
