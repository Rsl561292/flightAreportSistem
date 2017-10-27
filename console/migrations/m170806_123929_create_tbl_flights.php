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
            'type' => $this->char(1)->notNull()->defaultValue('1'),
            'direction' => $this->char(1)->notNull()->defaultValue('1'),
            'datetime_plane' => $this->dateTime()->notNull(),
            'datetime_fact' => $this->dateTime(),
            'plane_id' => $this->integer()->null()->unsigned(),
            'strip_id' => $this->integer()->null()->unsigned(),
            'status' => $this->char(1)->notNull()->defaultValue('1'),
            'visible' => $this->char(1)->notNull()->defaultValue('1'),
            'airport_id' => $this->integer()->null()->unsigned(),
            'begin_registration_plan' => $this->dateTime(),
            'end_registration_plan' => $this->dateTime(),
            'begin_registration_fact' => $this->dateTime(),
            'end_registration_fact' => $this->dateTime(),
            'begin_landing_plan' => $this->dateTime(),
            'end_landing_plan' => $this->dateTime(),
            'begin_landing_fact' => $this->dateTime(),
            'end_landing_fact' => $this->dateTime(),
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
