<?php

use yii\db\Migration;

class m170805_101717_create_tbl_baggage extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%baggage}}', [
            'id' => $this->primaryKey(),
            'passenger_id' => $this->integer()->notNull(),
            'weight' => $this->float()->notNull(),
            'status' => $this->char(2)->notNull()->defaultValue('0'),
            'description' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%baggage}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_101717_create_tbl_baggage cannot be reverted.\n";

        return false;
    }
    */
}
