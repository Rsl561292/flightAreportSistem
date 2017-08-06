<?php

use yii\db\Migration;

class m170805_113548_create_tbl_registration_desk_to_flight_plan extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%registration_desk_to_flight_plan}}', [
            'id' => $this->primaryKey(),
            'flight_plan_id' => $this->integer(11)->notNull(),
            'registration_desk_id' => $this->integer(11)->notNull(),
            'class_in_plane' => $this->char(1)->notNull()->defaultValue('0')
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%registration_desk_to_flight_plan}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_113548_create_tbl_registration_desk_to_flight_plan cannot be reverted.\n";

        return false;
    }
    */
}
