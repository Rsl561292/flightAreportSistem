<?php

use yii\db\Migration;

class m170805_121738_create_tbl_plane extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%plane}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'registration_code' => $this->string(20)->unique()->notNull(),
            'carrier_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'status_location' => $this->char(1)->notNull()->defaultValue('1'),
            'status_preparation' => $this->char(2)->notNull()->defaultValue('1')
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%plane}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_121738_create_tbl_plane cannot be reverted.\n";

        return false;
    }
    */
}
