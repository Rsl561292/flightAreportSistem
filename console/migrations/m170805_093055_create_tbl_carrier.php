<?php

use yii\db\Migration;

class m170805_093055_create_tbl_carrier extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%carrier}}', [
            'id' => $this->primaryKey(),
            'identification_code' => $this->string(30)->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'short_description' => $this->text(),
            'address_office' => $this->string(),
            'phone' => $this->string(20),
            'email' => $this->string(100),
            'status' => $this->char(1)->notNull()->defaultValue('0'),
            'description' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%carrier}}');
    }

    /*
   // Use up()/down() to run migration code without a transaction.
   public function up()
   {

   }

   public function down()
   {
       echo "m170805_093055_create_tbl_carrier cannot be reverted.\n";

       return false;
   }
   */
}
