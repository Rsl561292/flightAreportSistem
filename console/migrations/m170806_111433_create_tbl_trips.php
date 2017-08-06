<?php

use yii\db\Migration;

class m170806_111433_create_tbl_trips extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%trips}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'marking_trip' => $this->string(10)->unique()->notNull(),
            'date_construction_trip' => $this->date(),
            'type_surface' => $this->char(1)->notNull()->defaultValue('0'),
            'length' => $this->integer(11)->notNull(),
            'width' => $this->integer(11)->notNull(),
            'status' => $this->char(2)->notNull()->defaultValue('0'),
            'category' => $this->char(1)->notNull(),
            'description' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%trips}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_111433_create_tbl_trips cannot be reverted.\n";

        return false;
    }
    */
}
