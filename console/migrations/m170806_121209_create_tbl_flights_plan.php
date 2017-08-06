<?php

use yii\db\Migration;

class m170806_121209_create_tbl_flights_plan extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%flights_plan}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'date_flight' => $this->date()->notNull(),
            'time_flight' => $this->time()->notNull(),
            'direction_flight' => $this->char(1)->notNull(),
            'airline_id' => $this->integer(11),
            'type' => $this->char(1)->notNull(),
            'platform_id' => $this->integer(11),
            'trip_id' => $this->integer(11)->notNull(),
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
        $this->dropTable('{{%flights_plan}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_121209_create_tbl_flights_plan cannot be reverted.\n";

        return false;
    }
    */
}
