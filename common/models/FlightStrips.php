<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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
    const SURFACE_ASPHALT = '1';
    const SURFACE_CONCRETE = '2';
    const SURFACE_ASPHALT_CONCRETE = '3';

    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '2';

    const CATEGORY_I = '1';
    const CATEGORY_II = '2';
    const CATEGORY_IIIA = '3';
    const CATEGORY_IIIB = '4';
    const CATEGORY_IIIC = '5';
    const CATEGORY_NOT_PRECISE_MEASURE = '6';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flight_strips}}';
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
            [
                [
                    'marking', 'length_NDR',
                    'width', 'surface', 'category', 'status'
                ], 'required'
            ],
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
            [
                [
                    'length_NDR',
                    'bias_threshold',
                    'length_KSH',
                    'length_KZB',
                    'length_VZ',
                    'width',
                    'width_sidebar_safety'
                ], 'validateIsUnsigned'
            ],
            [['length_NDR', 'width'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            [['width'], 'compare', 'compareValue' => 250, 'operator' => '<', 'type' => 'number'],
            [['length_NDR'], 'compare', 'compareValue' => 400, 'operator' => '>', 'type' => 'number'],
            ['bias_threshold', 'validateBiasThreshold'],
            ['length_VZ', 'validateLengthVZ'],
            ['width_sidebar_safety', 'validateWidthSidebarSafety'],
            [['name'], 'string', 'max' => 255],
            [['marking'], 'string', 'max' => 15],
            [['marking'], 'unique'],
            [['surface', 'category'], 'string', 'max' => 1],
            ['surface', 'in', 'range' => array_keys(self::getSurfaceList())],
            ['category', 'in', 'range' => array_keys(self::getCategoryList())],
            [['status'], 'string', 'max' => 2],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function validateIsUnsigned($attribute)
    {
        if (!$this->hasErrors($this->$attribute)) {

            if ($this->$attribute < 0 ) {

                $this->addError($attribute, 'Значення поля не може бути від\'ємним.');
            }
        }
    }

    public function validateBiasThreshold($attribute)
    {
        if (!$this->hasErrors('length_NDR') && !$this->hasErrors('bias_threshold')) {

            if (floatval($this->bias_threshold) >= (floatval($this->length_NDR) / 2)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['bias_threshold'].' має бути менше половини значення поля '.$labelList['length_NDR'].'.');
            }
        }
    }

    public function validateLengthVZ($attribute)
    {
        $labelList = $this->attributeLabels();

        if (!$this->hasErrors('length_VZ')) {

            if (!$this->hasErrors('length_NDR')) {

                if (floatval($this->length_VZ) >= (floatval($this->length_NDR) / 2)) {

                    $this->addError($attribute, 'Значення поля '.$labelList['length_VZ'].' має бути менше половини значення поля '.$labelList['length_NDR'].'.');

                    return true;
                }
            }

            if (!$this->hasErrors('length_KSH') && !$this->hasErrors('length_KZB')) {

                if (floatval($this->length_VZ) < (floatval($this->length_KSH) + floatval($this->length_KZB))) {

                    $this->addError($attribute, 'Значення поля '.$labelList['length_VZ'].' не може бути менше ніж сума полів '.$labelList['length_KSH'].' та '.$labelList['length_KZB'].'.');

                    return true;
                }
            }
        }

    }

    public function validateWidthSidebarSafety($attribute)
    {
        $labelList = $this->attributeLabels();

        if (!$this->hasErrors('width_sidebar_safety') && !$this->hasErrors('width')) {

            if (floatval($this->width_sidebar_safety) >= (floatval($this->width) / 2)) {

                $this->addError($attribute, 'Значення поля '.$labelList['width_sidebar_safety'].' має бути менше половини значення поля '.$labelList['width'].'.');
            }
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID запису',
            'name' => 'Найменування',
            'marking' => 'Маркування',
            'surface' => 'Покриття',
            'length_NDR' => 'Довжина НДР(м)',
            'bias_threshold' => 'Зміщення бар\'єру(м)',
            'length_KSH' => 'Довжина КСГ(м)',
            'length_KZB' => 'Довжина КЗБ(м)',
            'length_VZ' => 'Довжина ВС(м)',
            'width' => 'Ширина(м)',
            'width_sidebar_safety' => 'Ширина БСБ(м)',
            'status' => 'Статус',
            'category' => 'Категорія',
            'description' => 'Додаткова інформація',
            'user_id' => 'Користувач',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата обновлення',
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

    //=========================================================================================
    public static function getSurfaceList()
    {
        return [
            self::SURFACE_ASPHALT => 'Асфальтне',
            self::SURFACE_CONCRETE => 'Бетонне',
            self::SURFACE_ASPHALT_CONCRETE => 'Асфальтнобетонне',
        ];
    }

    public function getSurfaceName()
    {
        return ArrayHelper::getValue(self::getSurfaceList(), $this->surface, 'Невизначено');
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

    public static function getCategoryList()
    {
        return [
            self::CATEGORY_I => 'I',
            self::CATEGORY_II => 'II',
            self::CATEGORY_IIIA => 'IIIA',
            self::CATEGORY_IIIB => 'IIIB',
            self::CATEGORY_IIIC => 'IIIC',
            self::CATEGORY_NOT_PRECISE_MEASURE => 'ЗПС візульного заходу',
        ];
    }

    public function getCategoryName()
    {
        return ArrayHelper::getValue(self::getCategoryList(), $this->category, 'Невизначено');
    }

}
