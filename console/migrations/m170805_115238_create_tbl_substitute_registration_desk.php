<?php

use yii\db\Migration;

class m170805_115238_create_tbl_substitute_registration_desk extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%substitute_registration_desk}}', [
            'id' => $this->primaryKey(),
            'flight_id' => $this->integer(11)->notNull(),
            'desk_flight_plan_id' => $this->integer(11)->notNull(),
            'registration_desk_id' => $this->integer(11)->notNull(),
            'registration_class' => $this->char(1)->notNull()->defaultValue('0')
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%substitute_registration_desk}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_115238_create_tbl_substitute_registration_desk cannot be reverted.\n";

        return false;
    }
    */
}
