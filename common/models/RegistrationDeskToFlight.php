<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_registration_desk_to_flight".
 *
 * @property integer $id
 * @property string $flight_id
 * @property string $registration_desk_id
 * @property string $class
 */
class RegistrationDeskToFlight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_registration_desk_to_flight';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flight_id', 'registration_desk_id'], 'required'],
            [['flight_id', 'registration_desk_id'], 'integer'],
            [['class'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flight_id' => 'Flight ID',
            'registration_desk_id' => 'Registration Desk ID',
            'class' => 'Class',
        ];
    }
}
