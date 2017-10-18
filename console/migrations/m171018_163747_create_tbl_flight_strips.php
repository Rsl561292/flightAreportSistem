<?php

use yii\db\Migration;

class m171018_163747_create_tbl_flight_strips extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%flight_strips}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'marking' => $this->string(15)->unique()->notNull(),
            'surface' => $this->char(1)->notNull()->defaultValue('1'),
            'length_NDR' => $this->float()->unsigned()->notNull(),
            'bias_threshold' => $this->float()->unsigned()->null(),
            'length_KSH' => $this->float()->unsigned()->null(),
            'length_KZB' => $this->float()->unsigned()->null(),
            'length_VZ' => $this->float()->unsigned()->null(),
            'width' => $this->float()->unsigned()->notNull(),
            'width_sidebar_safety' => $this->float()->unsigned()->null(),
            'status' => $this->char(2)->notNull()->defaultValue('1'),
            'category' => $this->char(1)->notNull(),
            'description' => $this->text(),
            'user_id' => $this->integer()->unsigned()->null(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%flight_strips}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171018_163747_create_tbl_flight_strips cannot be reverted.\n";

        return false;
    }
    */
}
