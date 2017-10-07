<?php

use yii\db\Migration;

class m171001_082417_create_tbl_gis_country extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gis_country}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(32)->unique()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'status' => $this->char(1)->defaultValue('1'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%gis_country}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171001_082417_create_tbl_gis_country cannot be reverted.\n";

        return false;
    }
    */
}
