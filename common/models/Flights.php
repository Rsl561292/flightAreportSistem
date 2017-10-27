<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_flights".
 *
 * @property integer $id
 * @property string $type
 * @property string $direction
 * @property string $datetime_plane
 * @property string $datetime_fact
 * @property string $plane_id
 * @property string $strip_id
 * @property string $status
 * @property string $visible
 * @property string $airport_id
 * @property string $begin_registration_plan
 * @property string $end_registration_plan
 * @property string $begin_registration_fact
 * @property string $end_registration_fact
 * @property string $begin_landing_plan
 * @property string $end_landing_plan
 * @property string $begin_landing_fact
 * @property string $end_landing_fact
 */
class Flights extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_flights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_plane'], 'required'],
            [['datetime_plane', 'datetime_fact', 'begin_registration_plan', 'end_registration_plan', 'begin_registration_fact', 'end_registration_fact', 'begin_landing_plan', 'end_landing_plan', 'begin_landing_fact', 'end_landing_fact'], 'safe'],
            [['plane_id', 'strip_id', 'airport_id'], 'integer'],
            [['type', 'direction', 'status', 'visible'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'direction' => 'Direction',
            'datetime_plane' => 'Datetime Plane',
            'datetime_fact' => 'Datetime Fact',
            'plane_id' => 'Plane ID',
            'strip_id' => 'Strip ID',
            'status' => 'Status',
            'visible' => 'Visible',
            'airport_id' => 'Airport ID',
            'begin_registration_plan' => 'Begin Registration Plan',
            'end_registration_plan' => 'End Registration Plan',
            'begin_registration_fact' => 'Begin Registration Fact',
            'end_registration_fact' => 'End Registration Fact',
            'begin_landing_plan' => 'Begin Landing Plan',
            'end_landing_plan' => 'End Landing Plan',
            'begin_landing_fact' => 'Begin Landing Fact',
            'end_landing_fact' => 'End Landing Fact',
        ];
    }
}
