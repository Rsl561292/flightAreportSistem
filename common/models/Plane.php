<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_plane".
 *
 * @property integer $id
 * @property string $type_id
 * @property string $registration_code
 * @property string $carrier_id
 * @property string $status_location
 * @property string $status_preparation
 */
class Plane extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_plane';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'carrier_id'], 'integer'],
            [['registration_code'], 'required'],
            [['registration_code'], 'string', 'max' => 20],
            [['status_location'], 'string', 'max' => 1],
            [['status_preparation'], 'string', 'max' => 2],
            [['registration_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'registration_code' => 'Registration Code',
            'carrier_id' => 'Carrier ID',
            'status_location' => 'Status Location',
            'status_preparation' => 'Status Preparation',
        ];
    }
}
