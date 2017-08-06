<?php

use yii\db\Migration;

class m170805_103745_create_tbl_cargo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cargo}}', [
            'id' => $this->primaryKey(),
            'weight' => $this->float()->notNull(),
            'is_live' => $this->char(1)->notNull()->defaultValue('0'),
            'status_location' => $this->char(2)->notNull(),
            'width' => $this->float(),
            'length' => $this->float(),
            'height' => $this->float(),
            'owner_and_address' => $this->string(),
            'description' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%cargo}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_103745_create_tbl_cargo cannot be reverted.\n";

        return false;
    }
    */
}
