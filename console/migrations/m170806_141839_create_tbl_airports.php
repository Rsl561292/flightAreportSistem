<?php

use yii\db\Migration;

class m170806_141839_create_tbl_airports extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%airports}}', [
            'id' => $this->primaryKey(),
            'code_iata' => $this->char(4)->unique()->notNull(),
            'code_ikao' => $this->char(4),
            'name' => $this->string()->notNull(),
            'status' => $this->char(2)->notNull()->defaultValue('0'),
            'city_id' => $this->integer(11)->notNull(),
            'address' => $this->string(),
            'distance_to_airport' => $this->float()->notNull()->defaultValue(0),
            'latitude_coordinates' => $this->string(20),
            'longitude_coordinates' => $this->string(20),
            'height_sea' => $this->integer(),
            'begin_commandant_time' => $this->time(),
            'end_commandant_time' => $this->time(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%airports}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_141839_create_tbl_airports cannot be reverted.\n";

        return false;
    }
    */
}
