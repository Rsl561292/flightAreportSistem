<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_airports".
 *
 * @property integer $id
 * @property string $code_iata
 * @property string $code_ikao
 * @property string $name
 * @property string $country_id
 * @property string $region_id
 * @property string $city
 * @property string $other_address
 * @property double $distance_to_airport
 * @property string $begin_commandant_time
 * @property integer $commandant_time
 * @property string $status
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Airports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_airports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_iata', 'name', 'country_id', 'city'], 'required'],
            [['country_id', 'region_id', 'commandant_time', 'user_id'], 'integer'],
            [['distance_to_airport'], 'number'],
            [['begin_commandant_time', 'created_at', 'updated_at'], 'safe'],
            [['code_iata', 'code_ikao'], 'string', 'max' => 4],
            [['name', 'city', 'other_address'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 2],
            [['code_iata'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_iata' => 'Code Iata',
            'code_ikao' => 'Code Ikao',
            'name' => 'Name',
            'country_id' => 'Country ID',
            'region_id' => 'Region ID',
            'city' => 'City',
            'other_address' => 'Other Address',
            'distance_to_airport' => 'Distance To Airport',
            'begin_commandant_time' => 'Begin Commandant Time',
            'commandant_time' => 'Commandant Time',
            'status' => 'Status',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
