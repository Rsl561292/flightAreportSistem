<?php

use yii\db\Migration;

class m171103_101149_create_tbl_registration_desk_to_flight extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%registration_desk_to_flight}}', [
            'id' => $this->primaryKey(),
            'flight_id' => $this->integer()->notNull()->unsigned(),
            'registration_desk_id' => $this->integer()->notNull()->unsigned(),
            'class' => $this->char(1)->notNull()->defaultValue('1'),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%registration_desk_to_flight}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171103_101149_create_tbl_registration_desk_to_flight cannot be reverted.\n";

        return false;
    }
    */
}
