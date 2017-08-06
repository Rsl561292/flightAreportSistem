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
            'kind' => $this->char(1)->notNull(),
            'category_plane' => $this->char(1)->notNull(),
            'length' => $this->float()->notNull(),
            'wingspan' => $this->float()->notNull(),
            'needed_length_trip' => $this->integer(11)->notNull(),
            'weight_empty_plane' => $this->float()->notNull(),
            'height_fuselage' => $this->float(),
            'width_fuselage' => $this->float(),
            'height_salon' => $this->float(),
            'width_salon' => $this->float(),
            'max_take-off_mass' => $this->float()->notNull(),
            'max_load' =>  $this->float()->notNull(),
            'cruising_speed' => $this->float(),
            'max_speed' => $this->float()->notNull(),
            'cruising_height' => $this->integer(11),
            'max_height' => $this->integer(11),
            'max_distance_empty' => $this->float()->notNull(),
            'distance_one_load' => $this->float()->notNull(),
            'max_stock_fuel' => $this->float()->notNull(),
            'fuel_costs_empty' => $this->float()->notNull(),
            'fuel_costs_unit_weight' => $this->float()->notNull(),
            'max_number_seats' => $this->integer(11)->notNull()->defaultValue(0),
            'seats_business_class' => $this->integer(11)->notNull()->defaultValue(0),
            'count_crew' => $this->integer(11)->notNull()->defaultValue(2),
            'comment' => $this->text()
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
