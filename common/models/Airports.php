<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_airports".
 *
 * @property integer $id
 * @property string $code_iata
 * @property string $code_ikao
 * @property string $name
 * @property string $country_id
 * @property string $region_id
 * @property string $city
 * @property string $other_address
 * @property double $distance_to_airport
 * @property string $begin_commandant_time
 * @property integer $commandant_time
 * @property string $status
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Airports extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = '1';
    const STATUS_CLOSE = '2';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%airports}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('TIME(NOW())'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_iata', 'name', 'country_id', 'city', 'distance_to_airport', 'status'], 'required'],
            [['country_id', 'region_id', 'commandant_time', 'user_id'], 'integer'],
            ['commandant_time', 'validateCommandantTime'],
            [['country_id'], 'in', 'range' => array_keys(GisCountry::getAllCountryListId())],
            [['region_id'], 'in', 'range' => array_keys(GisRegions::getAllRegionsListId())],
            [['commandant_time'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'integer'],
            [['commandant_time'], 'compare', 'compareValue' => 1440, 'operator' => '<', 'type' => 'integer'],
            [['distance_to_airport'], 'number'],
            [['distance_to_airport'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            [['code_iata', 'code_ikao'], 'string', 'max' => 4],
            [['code_iata'], 'unique'],
            [['name', 'city', 'other_address'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 2],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['begin_commandant_time', 'created_at', 'updated_at'], 'safe'],
            ['commandant_time', 'default', 'value' => 0],
        ];
    }

    public function validateCommandantTime($attribute)
    {
        if (!$this->hasErrors('commandant_time')) {

            if (!$this->hasErrors('begin_commandant_time') && (intval($this->commandant_time) == 0) && (strlen($this->begin_commandant_time) !== 0)) {

                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Якщо задано значення поля '.$labelList['begin_commandant_time'].', то значення поля '.$labelList['commandant_time'].' має бути більше значення "0".');

                return true;
            }

            if (!$this->hasErrors('begin_commandant_time') && (strlen($this->begin_commandant_time) == 0) && intval($this->commandant_time) > 0) {

                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['commandant_time'].' не може бути більше "0", коли не задано значення поля '.$labelList['begin_commandant_time']);

                return true;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_iata' => 'Код IATA',
            'code_ikao' => 'Код IKAO',
            'name' => 'Найменування',
            'country_id' => 'Країна',
            'region_id' => 'Штат/регіон/обл.',
            'city' => 'Місто',
            'other_address' => 'Повна адреса',
            'distance_to_airport' => 'Відстань до аеропорту(м)',
            'begin_commandant_time' => 'Початок комендант. часу',
            'commandant_time' => 'Комендант. час триває(хв)',
            'status' => 'Статус',
            'user_id' => 'Користувач',
            'created_at' => 'Дата та час створення запису',
            'updated_at' => 'Дата та час останнього редагування запису',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if($this->user_id === null) {
                $this->user_id = Yii::$app->user->id;
            }

            return true;
        }

        return false;
    }

    //========================================================================================
    public function getCountry()
    {
        return $this->hasOne(GisCountry::className(), ['id' => 'country_id']);
    }

    public function getRegion()
    {
        return $this->hasOne(GisRegions::className(), ['id' => 'region_id']);
    }

    public function getFlights()
    {
        return $this->hasMany(Flights::className(), ['airport_id' => 'id']);
    }

    //==========================================================================================
    public static function getStatusList()
    {
        return [
            self::STATUS_OPEN => 'Відкритий',
            self::STATUS_CLOSE => 'Закритий',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }

    public static function getActiveRecordListId()
    {
        $list = (new Query())
            ->select('name')
            ->from(self::tableName())
            ->where(['status' => self::STATUS_OPEN])
            ->orderBy(['name' => SORT_ASC])
            ->indexBy('id')
            ->column();

        return $list;
    }

    public static function getAllRecordListId()
    {
        $list = (new Query())
            ->select('name')
            ->from(self::tableName())
            ->orderBy(['name' => SORT_ASC])
            ->indexBy('id')
            ->column();

        return $list;
    }
}
