<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Platform extends \yii\db\ActiveRecord
{
    const STATUS_WORKING_AND_OPEN = '1'; // в робочому стані та відкрита для прийняття
    const STATUS_WORKING_AND_CLOSE = '2'; // в робочому стані, але закрита для прийняття
    const STATUS_NOT_WORKING = '3'; // в не робочому стані

    const CONNECTING_ONLY_ACCESSORY_LADDER = '1'; //тільки підїздний трап
    const CONNECTING_ONLY_TRAIL = '2'; //є можливість тільки телетрапу
    const CONNECTING_ACCESSORY_LADDER_AND_TRAIL = '3'; //є можливість і телетрапу і під'їздного трапу

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%platform}}';
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
            [['symbol', 'type_connecting', 'status'], 'required'],
            [['terminal_id'], 'integer'],
            [['terminal_id'], 'in', 'range' => array_keys(Terminals::getTerminalsListAll())],
            [['width', 'length'], 'number'],
            [['symbol'], 'string', 'max' => 4],
            [['symbol'], 'unique'],
            [['name'], 'string', 'max' => 255],
            [['status', 'type_connecting'], 'string', 'max' => 2],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['type_connecting'], 'in', 'range' => array_keys(self::getTypeConnectingList())],
            [['description'], 'string'],
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
            'symbol' => 'См. позначення',
            'terminal_id' => 'Термінал',
            'name' => 'Найменування',
            'status' => 'Статус',
            'type_connecting' => 'Тип стикування з ПС',
            'width' => 'Ширина',
            'length' => 'Висота',
            'description' => 'Опис',
            'created_at' => 'Дата створення запису',
            'updated_at' => 'Дата оновлення запису',
        ];
    }

    public function getTerminals()
    {
        return $this->hasOne(Terminals::className(), ['id' => 'terminal_id']);
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

    public static function getTypeConnectingList()
    {
        return [
            self::CONNECTING_ACCESSORY_LADDER_AND_TRAIL => 'І під\'їздний трап та телетрап',
            self::CONNECTING_ONLY_ACCESSORY_LADDER => 'Тільки підїздний трап',
            self::CONNECTING_ONLY_TRAIL => 'Тільки телетрап',
        ];
    }

    public function getTypeConnectingName()
    {
        return ArrayHelper::getValue(self::getTypeConnectingList(), $this->type_connecting, 'Невизначений');
    }
}
