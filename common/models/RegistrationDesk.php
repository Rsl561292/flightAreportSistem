<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_registration_desk".
 *
 * @property integer $id
 * @property string $symbol
 * @property integer $terminal_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $description
 */
class RegistrationDesk extends \yii\db\ActiveRecord
{
    const STATUS_WORKING_AND_OPEN = '1'; // в робочому стані та відкрита для прийняття
    const STATUS_WORKING_AND_CLOSE = '2'; // в робочому стані, але закрита для прийняття
    const STATUS_NOT_WORKING = '3'; // в не робочому стані
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%registration_desk}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['symbol', 'status'], 'required'],
            [['terminal_id'], 'integer'],
            [['terminal_id'], 'in', 'range' => array_keys(Terminals::getTerminalsListAll())],
            [['description'], 'string'],
            [['symbol'], 'string', 'max' => 5],
            [['symbol'], 'unique'],
            [['status'], 'string', 'max' => 2],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getTerminals()
    {
        return $this->hasOne(Terminals::className(), ['id' => 'terminal_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'См. позначення',
            'terminal_id' => 'Термінал',
            'status' => 'Статус',
            'description' => 'Опис',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_WORKING_AND_OPEN => 'Робочий та відкритий',
            self::STATUS_WORKING_AND_CLOSE => 'Робочий, але закритий',
            self::STATUS_NOT_WORKING => 'Не робочий',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }
}
