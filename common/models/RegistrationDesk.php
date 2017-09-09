<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_registration_desk".
 *
 * @property integer $id
 * @property string $symbol
 * @property integer $terminal_id
 * @property string $status
 * @property string $description
 */
class RegistrationDesk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_registration_desk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['symbol'], 'required'],
            [['terminal_id'], 'integer'],
            [['description'], 'string'],
            [['symbol'], 'string', 'max' => 5],
            [['status'], 'string', 'max' => 2],
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
            'status' => 'Status',
            'description' => 'Description',
        ];
    }
}
