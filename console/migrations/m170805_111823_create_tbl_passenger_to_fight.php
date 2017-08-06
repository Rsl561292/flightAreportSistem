<?php

use yii\db\Migration;

class m170805_111823_create_tbl_passenger_to_fight extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%passenger_to_fight}}', [
            'id' => $this->primaryKey(),
            'passenger_id' => $this->integer(11)->notNull(),
            'flight_id' => $this->integer(11)->notNull(),
            'status_passenger' => $this->char(2)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%passenger_to_fight}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_111823_create_tbl_passenger_to_fight cannot be reverted.\n";

        return false;
    }
    */
}
