<?php

use yii\db\Migration;

class m170805_094324_create_tbl_passengers extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%passengers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'date' => $this->date()->notNull(),
            'address' => $this->string(),
            'registration' => $this->char(1)->notNull()->defaultValue('0'),
            'aviation_security' => $this->char(1)->notNull()->defaultValue('0'),
            'passport_control' => $this->char(1)->notNull()->defaultValue('0'),
            'customs_control' => $this->char(1)->notNull()->defaultValue('0'),
            'comment' => $this->text(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%passengers}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_094324_create_tbl_passengers cannot be reverted.\n";

        return false;
    }
    */
}
