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
            'country_id' => $this->integer()->unsigned()->notNull(),
            'region_id' => $this->integer()->unsigned()->null(),
            'city' => $this->string()->notNull(),
            'other_address' => $this->string(),
            'distance_to_airport' => $this->float()->unsigned()->notNull()->defaultValue(0),
            'begin_commandant_time' => $this->time(),
            'commandant_time' => $this->smallInteger(2)->unsigned()->defaultValue(0),
            'status' => $this->char(2)->notNull()->defaultValue('0'),
            'user_id' => $this->integer()->unsigned()->null(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
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
