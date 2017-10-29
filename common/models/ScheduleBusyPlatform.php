<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_schedule_busy_platform".
 *
 * @property integer $id
 * @property string $platform_id
 * @property string $plane_id
 * @property string $flight_id
 * @property string $status
 * @property string $begin_busy_plan
 * @property string $end_busy_plan
 * @property string $begin_busy_fact
 * @property string $end_busy_fact
 */
class ScheduleBusyPlatform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_schedule_busy_platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'plane_id'], 'required'],
            [['platform_id', 'plane_id', 'flight_id'], 'integer'],
            [['begin_busy_plan', 'end_busy_plan', 'begin_busy_fact', 'end_busy_fact'], 'safe'],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platform_id' => 'Platform ID',
            'plane_id' => 'Plane ID',
            'flight_id' => 'Flight ID',
            'status' => 'Status',
            'begin_busy_plan' => 'Begin Busy Plan',
            'end_busy_plan' => 'End Busy Plan',
            'begin_busy_fact' => 'Begin Busy Fact',
            'end_busy_fact' => 'End Busy Fact',
        ];
    }
}
