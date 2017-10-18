<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_flight_strips".
 *
 * @property integer $id
 * @property string $name
 * @property string $marking
 * @property string $surface
 * @property double $length_NDR
 * @property double $bias_threshold
 * @property double $length_KSH
 * @property double $length_KZB
 * @property double $length_VZ
 * @property double $width
 * @property double $width_sidebar_safety
 * @property string $status
 * @property string $category
 * @property string $description
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class FlightStrips extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_flight_strips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marking', 'length_NDR', 'width', 'category'], 'required'],
            [
                [
                    'length_NDR',
                    'bias_threshold',
                    'length_KSH',
                    'length_KZB',
                    'length_VZ',
                    'width',
                    'width_sidebar_safety'
                ], 'number'
            ],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['marking'], 'string', 'max' => 15],
            [['surface', 'category'], 'string', 'max' => 1],
            [['status'], 'string', 'max' => 2],
            [['marking'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'marking' => 'Marking',
            'surface' => 'Surface',
            'length_NDR' => 'Length  Ndr',
            'bias_threshold' => 'Bias Threshold',
            'length_KSH' => 'Length  Ksh',
            'length_KZB' => 'Length  Kzb',
            'length_VZ' => 'Length  Vz',
            'width' => 'Width',
            'width_sidebar_safety' => 'Width Sidebar Safety',
            'status' => 'Status',
            'category' => 'Category',
            'description' => 'Description',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
