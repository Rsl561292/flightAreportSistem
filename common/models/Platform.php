<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_platform".
 *
 * @property integer $id
 * @property string $symbol
 * @property integer $terminal_id
 * @property string $name
 * @property string $status
 * @property string $type_connecting
 * @property double $width
 * @property double $length
 * @property string $created_at
 * @property string $updated_at
 */
class Platform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['symbol', 'width', 'length', 'created_at', 'updated_at'], 'required'],
            [['terminal_id'], 'integer'],
            [['width', 'length'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['symbol'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 255],
            [['status', 'type_connecting'], 'string', 'max' => 2],
            [['symbol'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'terminal_id' => 'Terminal ID',
            'name' => 'Name',
            'status' => 'Status',
            'type_connecting' => 'Type Connecting',
            'width' => 'Width',
            'length' => 'Length',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
