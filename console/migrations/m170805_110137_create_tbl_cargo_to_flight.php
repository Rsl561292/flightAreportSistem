<?php

use yii\db\Migration;

class m170805_110137_create_tbl_cargo_to_flight extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cargo_to_flight}}', [
            'id' => $this->primaryKey(),
            'cargo_id' => $this->integer(11)->notNull(),
            'flight_id' => $this->integer(11)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%cargo_to_flight}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_110137_create_tbl_cargo_to_flight cannot be reverted.\n";

        return false;
    }
    */
}
