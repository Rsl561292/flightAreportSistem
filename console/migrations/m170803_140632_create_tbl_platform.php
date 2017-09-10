<?php

use yii\db\Migration;

class m170803_140632_create_tbl_platform extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%platform}}', [
            'id' => $this->primaryKey(),
            'symbol' => $this->char(4)->notNull()->unique(),
            'terminal_id' => $this->integer(11),
            'name' => $this->string(),
            'status' => $this->char(2)->notNull()->defaultValue('1'),
            'type_connecting' => $this->char(2)->notNull()->defaultValue('3'),
            'width' => $this->float(),
            'length' => $this->float(),
            'description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%platform}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_140632_create_tbl_platform cannot be reverted.\n";

        return false;
    }
    */
}
