<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_carrier".
 *
 * @property integer $id
 * @property string $identification_code
 * @property string $name
 * @property string $short_description
 * @property string $country_id
 * @property string $region_id
 * @property string $city
 * @property string $other_address
 * @property string $phone
 * @property string $email
 * @property string $status
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Carrier extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1'; // Активний
    const STATUS_INACTIVE = '2'; // Не активний

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carrier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identification_code', 'name'], 'required'],
            [['short_description', 'description'], 'string'],
            [['country_id', 'region_id'], 'integer'],
            [['identification_code'], 'string', 'max' => 30],
            [['name', 'city', 'other_address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 1],
            [['identification_code'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identification_code' => 'Identification Code',
            'name' => 'Name',
            'short_description' => 'Short Description',
            'country_id' => 'Country ID',
            'region_id' => 'Region ID',
            'city' => 'City',
            'other_address' => 'Other Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'status' => 'Status',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
