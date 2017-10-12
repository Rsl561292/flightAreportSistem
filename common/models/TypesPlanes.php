<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_types_planes".
 *
 * @property integer $id
 * @property string $full_name_type
 * @property string $marking
 * @property string $kind
 * @property string $category_plane
 * @property double $length
 * @property double $wingspan
 * @property string $need_length_trip
 * @property double $weight_empty_plane
 * @property double $height_fuselage
 * @property double $width_fuselage
 * @property double $height_salon
 * @property double $width_salon
 * @property double $max_take-off_mass
 * @property double $max_load
 * @property double $cruising_speed
 * @property double $max_speed
 * @property string $cruising_height
 * @property string $max_height
 * @property double $max_distance_empty
 * @property double $distance_one_load
 * @property double $max_stock_fuel
 * @property double $fuel_costs_empty
 * @property double $fuel_costs_unit_weight
 * @property string $max_number_seats
 * @property string $seats_business_class
 * @property string $count_crew
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 */
class TypesPlanes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_types_planes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name_type', 'marking', 'kind', 'category_plane', 'length', 'wingspan', 'need_length_trip', 'weight_empty_plane', 'max_take-off_mass', 'max_load', 'max_speed', 'max_distance_empty', 'distance_one_load', 'max_stock_fuel', 'fuel_costs_empty', 'fuel_costs_unit_weight'], 'required'],
            [['length', 'wingspan', 'weight_empty_plane', 'height_fuselage', 'width_fuselage', 'height_salon', 'width_salon', 'max_take-off_mass', 'max_load', 'cruising_speed', 'max_speed', 'max_distance_empty', 'distance_one_load', 'max_stock_fuel', 'fuel_costs_empty', 'fuel_costs_unit_weight'], 'number'],
            [['need_length_trip', 'cruising_height', 'max_height', 'max_number_seats', 'seats_business_class', 'count_crew'], 'integer'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['full_name_type'], 'string', 'max' => 255],
            [['marking'], 'string', 'max' => 30],
            [['kind', 'category_plane'], 'string', 'max' => 1],
            [['full_name_type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name_type' => 'Full Name Type',
            'marking' => 'Marking',
            'kind' => 'Kind',
            'category_plane' => 'Category Plane',
            'length' => 'Length',
            'wingspan' => 'Wingspan',
            'need_length_trip' => 'Need Length Trip',
            'weight_empty_plane' => 'Weight Empty Plane',
            'height_fuselage' => 'Height Fuselage',
            'width_fuselage' => 'Width Fuselage',
            'height_salon' => 'Height Salon',
            'width_salon' => 'Width Salon',
            'max_take-off_mass' => 'Max Take Off Mass',
            'max_load' => 'Max Load',
            'cruising_speed' => 'Cruising Speed',
            'max_speed' => 'Max Speed',
            'cruising_height' => 'Cruising Height',
            'max_height' => 'Max Height',
            'max_distance_empty' => 'Max Distance Empty',
            'distance_one_load' => 'Distance One Load',
            'max_stock_fuel' => 'Max Stock Fuel',
            'fuel_costs_empty' => 'Fuel Costs Empty',
            'fuel_costs_unit_weight' => 'Fuel Costs Unit Weight',
            'max_number_seats' => 'Max Number Seats',
            'seats_business_class' => 'Seats Business Class',
            'count_crew' => 'Count Crew',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
