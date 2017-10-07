<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_gis_regions".
 *
 * @property integer $id
 * @property string $country_id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class GisRegions extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1'; // Активний
    const STATUS_INACTIVE = '2'; // Не активний

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gis_regions}}';
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
            [['country_id', 'name', 'status'], 'required'],
            [['country_id'], 'integer'],
            [['code'], 'string', 'max' => 32],
            ['code', 'validateIsRegionInCountryOnCode'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['name', 'validateIsRegionInCountryOnName'],
            [['status'], 'string', 'max' => 1],
            [['status'], 'in', 'range' => array_keys(self::getStatusList())],
            [['country_id'], 'in', 'range' => array_keys(GisCountry::getAllCountryListId())],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function validateIsRegionInCountryOnName($attribute,$params)
    {
        $query = GisRegions::find()
            ->where([
                'country_id' => $this->country_id,
                'name' => $this->$attribute
            ]);
        if (!$this->isNewRecord) {
            $query->andWhere(['not', ['id' => $this->id]]);
        }

        if($query->exists()){
            $this->addError($attribute,'Штат/регіон/обл. з таким найменуванням уже існує для вибраної вами країни.');
        }
    }

    public function validateIsRegionInCountryOnCode($attribute,$params)
    {
        $query = GisRegions::find()
            ->where([
                'country_id' => $this->country_id,
                'code' => $this->$attribute
            ]);
        if (!$this->isNewRecord) {
            $query->andWhere(['not', ['id' => $this->id]]);
        }

        if($query->exists()){
            $this->addError($attribute,'Штат/регіон/обл. з таким кодом уже існує для вибраної вами країни.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Країна',
            'code' => 'Код регіону/штату',
            'name' => 'Найменування',
            'slug' => 'Слаг',
            'status' => 'Статус',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата оновлення',
        ];
    }

    public function getCountry()
    {
        return $this->hasOne(GisCountry::className(), ['id' => 'country_id']);
    }

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

    public function beforeSave($insert)
    {
        $this->slug = strtr(mb_strtolower($this->name), ' ', '-');

        return true;
    }
}
