<?php

use yii\db\Migration;

class m170805_180752_create_tbl_types_planes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%types_planes}}', [
            'id' => $this->primaryKey(),
            'full_name_type' => $this->string()->unique()->notNull(),
            'marking' => $this->string(30)->notNull(),
            'kind' => $this->char(1)->notNull(),
            'category_plane' => $this->char(1)->notNull(),
            'length' => $this->float()->unsigned()->notNull(),
            'wingspan' => $this->float()->unsigned()->notNull(),
            'need_length_trip' => $this->integer()->unsigned()->notNull(),
            'weight_empty_plane' => $this->float()->unsigned()->notNull(),
            'height_fuselage' => $this->float()->unsigned()->defaultValue(0),
            'width_fuselage' => $this->float()->unsigned()->defaultValue(0),
            'height_salon' => $this->float()->unsigned()->defaultValue(0),
            'width_salon' => $this->float()->unsigned()->defaultValue(0),
            'max_take_off_mass' => $this->float()->unsigned()->notNull(),
            'max_load' =>  $this->float()->unsigned()->notNull(),
            'cruising_speed' => $this->float()->unsigned()->defaultValue(0),
            'max_speed' => $this->float()->unsigned()->notNull(),
            'cruising_height' => $this->integer()->unsigned()->defaultValue(0),
            'max_height' => $this->integer()->unsigned()->defaultValue(0),
            'max_distance_empty' => $this->float()->unsigned()->notNull(),
            'distance_one_load' => $this->float()->unsigned()->notNull(),
            'max_stock_fuel' => $this->float()->unsigned()->notNull(),
            'fuel_costs_empty' => $this->float()->unsigned()->notNull(),
            'fuel_costs_unit_weight' => $this->float()->unsigned()->notNull(),
            'max_number_seats' => $this->integer()->unsigned()->defaultValue(0),
            'seats_business_class' => $this->integer()->unsigned()->defaultValue(0),
            'count_crew' => $this->integer()->notNull()->unsigned()->notNull()->defaultValue(2),
            'comment' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%types_planes}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170805_180752_create_tbl_types_planes cannot be reverted.\n";

        return false;
    }
    */
}
