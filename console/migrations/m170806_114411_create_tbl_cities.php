<?php

use yii\db\Migration;

class m170806_114411_create_tbl_cities extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gis_cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'state_id' => $this->integer()->unsigned(),
            'country_code' => $this->string(32),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%gis_cities}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_114411_create_tbl_cities cannot be reverted.\n";

        return false;
    }
    */
}
