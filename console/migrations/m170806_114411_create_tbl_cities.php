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

        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'region_id' => $this->string(10)->notNull(),
            'country_id' => $this->string(4)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%cities}}');
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
