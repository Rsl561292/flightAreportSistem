<?php

use yii\db\Migration;

class m170806_123929_create_tbl_flights extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%flights}}', [
            'id' => $this->primaryKey(),
            'main_flight_id' => $this->integer(11),
            'date_time' => $this->dateTime()->notNull(),
            'platform_id' => $this->integer(11),
            'plane_id' => $this->integer(11)->defaultValue(0),
            'status' => $this->char(1)->notNull()->defaultValue('0'),
            'trip_id' => $this->integer(11)->notNull(),
            'count_passengers' => $this->integer(11)->defaultValue(0),
            'weight_load' => $this->float()->defaultValue(0),
            'datetime_begin_platform' => $this->dateTime(),
            'datetime_end_platform' => $this->dateTime(),
            'datetime_begin_registration' => $this->dateTime(),
            'datetime_end_registration' => $this->dateTime(),
            'datetime_begin_landing' => $this->dateTime(),
            'datetime_end_landing' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%flights}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_123929_create_tbl_flights cannot be reverted.\n";

        return false;
    }
    */
}
