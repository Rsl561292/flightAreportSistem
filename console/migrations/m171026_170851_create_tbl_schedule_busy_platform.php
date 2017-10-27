<?php

use yii\db\Migration;

class m171026_170851_create_tbl_schedule_busy_platform extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%schedule_busy_platform}}', [
            'id' => $this->primaryKey(),
            'plane_id' => $this->integer()->notNull()->unsigned(),
            'flight_id' => $this->integer()->null()->unsigned(),
            'status' => $this->char(1)->notNull()->defaultValue('1'),
            'begin_busy_plan' => $this->dateTime(),
            'end_busy_plan' => $this->dateTime(),
            'begin_busy_fact' => $this->dateTime(),
            'end_busy_fact' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%schedule_busy_platform}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171026_170851_create_tbl_schedule_busy_platform cannot be reverted.\n";

        return false;
    }
    */
}
