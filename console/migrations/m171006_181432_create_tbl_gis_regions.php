<?php

use yii\db\Migration;

class m171006_181432_create_tbl_gis_regions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gis_regions}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->unsigned()->notNull(),
            'code' => $this->string(32),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'status' => $this->char(1)->notNull()->defaultValue('1'),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%gis_regions}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171006_181432_create_tbl_gis_regions cannot be reverted.\n";

        return false;
    }
    */
}
