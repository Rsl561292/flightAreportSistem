<?php

use yii\db\Migration;

class m170803_145815_create_tbl_registration_desk extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%registration_desk}}', [
            'id' => $this->primaryKey(),
            'symbol' => $this->string(5)->notNull()->unique(),
            'terminal_id' => $this->integer(11),
            'status' => $this->char(2)->notNull()->defaultValue('2'),
            'description' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%registration_desk}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_145815_create_tbl_registration_desk cannot be reverted.\n";

        return false;
    }
    */
}
