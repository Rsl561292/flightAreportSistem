<?php

use yii\db\Migration;

class m170806_115511_create_tbl_airlines extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%airlines}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(11)->notNull(),
            'airport_id' => $this->integer(11)->notNull(),
            'time_begin_registration' => $this->integer(11),
            'time_end_registration' => $this->integer(11),
            'time_begin_landing' => $this->integer(11),
            'time_end_landing' => $this->integer(11),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%airlines}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_115511_create_tbl_airlines cannot be reverted.\n";

        return false;
    }
    */
}
