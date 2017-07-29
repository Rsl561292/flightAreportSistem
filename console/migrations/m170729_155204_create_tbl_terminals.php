<?php

use yii\db\Migration;

class m170729_155204_create_tbl_terminals extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%terminals}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Повне найменування терміналу'),
            'symbol' => $this->string()->notNull()->unique()->comment('Символьне позначення'),
            'year_built' => $this->char(1)->comment('Рік побудови'),
            'status' => $this->char(1)->notNull()->comment('Статус'),
            'area' => $this->float()->comment('Площа терміналу'),
            'description' => $this->text()->comment('Опис'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%terminal}}');
    }
}
