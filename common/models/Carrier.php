<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_carrier".
 *
 * @property integer $id
 * @property string $identification_code
 * @property string $name
 * @property string $short_description
 * @property string $country_id
 * @property string $region_id
 * @property string $city
 * @property string $other_address
 * @property string $phone
 * @property string $email
 * @property string $status
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Carrier extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1'; // Активний
    const STATUS_INACTIVE = '2'; // Не активний

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%carrier}}';
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
            [['identification_code', 'name', 'status'], 'required'],
            [['short_description', 'description'], 'string'],
            [['country_id', 'region_id'], 'integer'],
            [['country_id'], 'in', 'range' => array_keys(GisCountry::getAllCountryListId())],
            [['region_id'], 'in', 'range' => array_keys(GisRegions::getAllRegionsListId())],
            [['identification_code'], 'string', 'max' => 30],
            [['name', 'city', 'other_address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            ['email', 'email'],
            [['status'], 'string', 'max' => 1],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['identification_code'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['identification_code', 'name', 'city', 'other_address', 'phone', 'email'], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identification_code' => 'Ідентифікаційний код',
            'name' => 'Найменування',
            'short_description' => 'Короткий опис',
            'country_id' => 'Країна',
            'region_id' => 'Штат/регіон/обл.',
            'city' => 'Місто',
            'other_address' => 'Повна адреса',
            'phone' => 'Телефон',
            'email' => 'Емеїл',
            'status' => 'Статус',
            'description' => 'Опис',
            'created_at' => 'Дата створення запису',
            'updated_at' => 'Дата оновлення запису',
        ];
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

    public function getPlane()
    {
        return $this->hasMany(Plane::className(), ['carrier_id' => 'id']);
    }

    //==========================================================================================
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активний',
            self::STATUS_INACTIVE => 'Не активний',
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
            ->where(['status' => self::STATUS_ACTIVE])
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
