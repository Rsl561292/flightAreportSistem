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
            [['country_id', 'name', 'slug'], 'required'],
            [['country_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 32],
            [['name', 'slug'], 'string', 'max' => 255],
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
            'country_id' => 'Країна',
            'code' => 'Код в країні',
            'name' => 'Найменування',
            'slug' => 'Слаг',
            'status' => 'Статус',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата оновлення',
        ];
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
}
