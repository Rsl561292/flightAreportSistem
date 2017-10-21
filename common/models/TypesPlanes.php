<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_types_planes".
 *
 * @property integer $id
 * @property string $full_name_type
 * @property string $marking
 * @property string $kind
 * @property double $length
 * @property double $wingspan
 * @property double $wing_area
 * @property double $width_chassis
 * @property double $length_take_off
 * @property double $length_landing
 * @property double $weight_empty_plane
 * @property double $height_fuselage
 * @property double $width_fuselage
 * @property double $height_salon
 * @property double $width_salon
 * @property double $max_take_off_mass
 * @property double $max_load
 * @property double $cruising_speed
 * @property double $max_speed
 * @property string $cruising_height
 * @property string $max_height
 * @property double $max_distance_empty
 * @property double $distance_one_load
 * @property double $max_stock_fuel
 * @property double $fuel_costs_empty
 * @property double $fuel_costs_unit_weight
 * @property string $max_number_seats
 * @property string $seats_business_class
 * @property string $count_crew
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 */
class TypesPlanes extends \yii\db\ActiveRecord
{
    const KIND_PASSENGER = '1';
    const KIND_FREINHT = '2';

    const CATEGORY_A = 'A';
    const CATEGORY_B = 'B';
    const CATEGORY_C = 'C';
    const CATEGORY_D = 'D';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%types_planes}}';
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
                    'full_name_type', 'marking', 'kind', 'length', 'wingspan', 'wing_area', 'width_chassis',
                    'length_take_off', 'length_landing', 'weight_empty_plane', 'max_take_off_mass', 'max_load',
                    'max_speed', 'max_distance_empty', 'distance_one_load', 'max_stock_fuel',
                    'fuel_costs_empty', 'fuel_costs_unit_weight', 'count_crew'
                ],
                'required'
            ],
            [
                [
                    'length', 'wingspan', 'wing_area', 'width_chassis', 'length_take_off', 'length_landing',
                    'weight_empty_plane', 'height_fuselage',
                    'width_fuselage', 'height_salon', 'width_salon', 'max_take_off_mass',
                    'max_load', 'cruising_speed', 'max_speed', 'max_distance_empty',
                    'distance_one_load', 'max_stock_fuel', 'fuel_costs_empty',
                    'fuel_costs_unit_weight'
                ],
                'number'
            ],
            [['max_distance_empty', 'distance_one_load'], 'validateDistance'],
            [['max_speed', 'cruising_speed'], 'validateSpeed'],
            [['max_take_off_mass'], 'validateMaxTakeOffMass'],
            [['max_stock_fuel'], 'validateStockFuelCostsEmpty'],
            [['max_stock_fuel'], 'validateStockFuelUnitWeight'],
            [['fuel_costs_unit_weight'], 'validateFuelUsing'],
            ['length_take_off', 'validateLengthTakeOff'],
            ['wingspan', 'validateWingspan'],
            ['height_fuselage', 'validateHeightFuselage'],
            ['width_fuselage', 'validateWidthFuselage'],
            [
                [
                    'cruising_height', 'max_height',
                    'max_number_seats', 'seats_business_class', 'count_crew'
                ],
                'integer'
            ],
            [
                [
                    'length', 'wingspan', 'wing_area', 'width_chassis', 'length_take_off',
                    'length_landing', 'weight_empty_plane', 'height_fuselage',
                    'width_fuselage', 'height_salon', 'width_salon', 'max_take_off_mass',
                    'max_load', 'cruising_speed', 'max_speed', 'max_distance_empty',
                    'distance_one_load', 'max_stock_fuel', 'fuel_costs_empty',
                    'fuel_costs_unit_weight', 'cruising_height', 'max_height',
                    'max_number_seats', 'seats_business_class', 'count_crew'
                ],
                'validateIsUnsigned'
            ],
            [['max_number_seats', 'seats_business_class'], 'validateCountSeats'],
            ['max_number_seats', 'validateMaxNumberSeats'],
            [['cruising_height', 'max_height'], 'validateHeight'],
            [['full_name_type'], 'string', 'max' => 255],
            [['full_name_type'], 'unique'],
            [['marking'], 'string', 'max' => 30],
            [['kind'], 'string', 'max' => 1],
            [['kind'], 'in', 'range' => array_keys(self::getKindList())],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['height_fuselage', 'width_fuselage', 'height_salon', 'width_salon', 'cruising_height', 'max_number_seats', 'seats_business_class'], 'default', 'value' => 0]
        ];
    }

    public function validateCountSeats($attribute)
    {
        if (!$this->hasErrors('max_number_seats') && !$this->hasErrors('seats_business_class')) {

            if (intval($this->max_number_seats) < intval($this->seats_business_class)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_number_seats'].' не може бути менше за поле '.$labelList['seats_business_class'].'.');
            }
        }
    }

    public function validateDistance($attribute)
    {
        if (!$this->hasErrors('max_distance_empty') && !$this->hasErrors('distance_one_load')) {

            if (floatval($this->max_distance_empty) < floatval($this->distance_one_load)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_distance_empty'].' не може бути менше за поле '.$labelList['distance_one_load'].'.');
            }
        }
    }

    public function validateHeight($attribute)
    {
        if (!$this->hasErrors('max_height') && !$this->hasErrors('cruising_height')) {

            if (intval($this->max_height) < intval($this->cruising_height)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_height'].' не може бути менше за поле '.$labelList['cruising_height'].'.');
            }
        }
    }

    public function validateSpeed($attribute)
    {
        if (!$this->hasErrors('max_speed') && !$this->hasErrors('cruising_speed')) {

            if (floatval($this->max_speed) < floatval($this->cruising_speed)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_speed'].' не може бути менше за поле '.$labelList['cruising_speed'].'.');
            }
        }
    }

    public function validateStockFuelCostsEmpty($attribute)
    {
        if (!$this->hasErrors('max_stock_fuel') && !$this->hasErrors('fuel_costs_empty')) {

            if (floatval($this->max_stock_fuel) <= floatval($this->fuel_costs_empty)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_stock_fuel'].' не може бути менше чи рівне ніж в полі '.$labelList['fuel_costs_empty']);
            }
        }
    }

    public function validateStockFuelUnitWeight($attribute)
    {
        if (!$this->hasErrors('max_stock_fuel') && !$this->hasErrors('fuel_costs_unit_weight')) {

            if (floatval($this->max_stock_fuel) <= floatval($this->fuel_costs_unit_weight)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_stock_fuel'].' не може бути менше чи рівне ніж в полі '.$labelList['fuel_costs_unit_weight']);
            }
        }
    }

    public function validateFuelUsing($attribute)
    {
        if (!$this->hasErrors('fuel_costs_unit_weight') && !$this->hasErrors('fuel_costs_empty')) {

            if (floatval($this->fuel_costs_unit_weight) < floatval($this->fuel_costs_empty)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['fuel_costs_unit_weight'].' не може бути менше ніж в полі '.$labelList['fuel_costs_empty']);
            }
        }
    }

    public function validateMaxTakeOffMass($attribute)
    {
        if (!$this->hasErrors('max_take_off_mass')) {
            $labelList = $this->attributeLabels();

            if (floatval($this->max_take_off_mass) < 0) {

                $this->addError($attribute, 'Значення поля '.$labelList['max_take_off_mass'].' повинно бути більше за 0');
            } else {
                if (!$this->hasErrors('weight_empty_plane') && !$this->hasErrors('max_load') && !$this->hasErrors('max_stock_fuel')) {

                    if (floatval($this->max_take_off_mass) < (floatval($this->weight_empty_plane) + floatval($this->max_load) +floatval($this->max_stock_fuel))) {

                        $this->addError($attribute, 'Значення поля '.$labelList['max_take_off_mass'].' не може бути менше ніж сума значень полів '.$labelList['weight_empty_plane'].', '.$labelList['max_load'].', '.$labelList['max_stock_fuel'].'.');
                    }
                }
            }
        }
    }

    public function validateLengthTakeOff($attribute)
    {
        if (!$this->hasErrors('length_take_off') && !$this->hasErrors('length_landing')) {

            if (floatval($this->length_take_off) <= floatval($this->length_landing)) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['length_take_off'].' має бути більшим за значення поля '.$labelList['length_landing']);
            }
        }
    }

    public function validateWingspan($attribute)
    {
        if (!$this->hasErrors('wingspan')) {

            if (!$this->hasErrors('width_chassis') && (floatval($this->wingspan) <= floatval($this->width_chassis))) {

                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['wingspan'].' має бути більшим за значення поля '.$labelList['width_chassis']);

                return true;
            }

            if (!$this->hasErrors('width_fuselage') && (floatval($this->wingspan) <= floatval($this->width_fuselage))) {

                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['wingspan'].' має бути більшим за значення поля '.$labelList['width_fuselage']);

                return true;
            }
        }

        return true;
    }

    public function validateWidthFuselage($attribute)
    {
        if (!$this->hasErrors('width_fuselage')) {

            if (!$this->hasErrors('width_salon') && (floatval($this->width_fuselage) <= floatval($this->width_salon)) && floatval($this->width_salon) > 0) {

                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['width_fuselage'].' має бути більшим за значення поля '.$labelList['width_salon']);

                return true;
            }
        }

        return true;
    }

    public function validateHeightFuselage($attribute)
    {
        if (!$this->hasErrors('height_fuselage')) {

            if (!$this->hasErrors('height_salon') && (floatval($this->height_fuselage) <= floatval($this->height_salon)) && floatval($this->height_salon) > 0) {

                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['height_fuselage'].' має бути більшим за значення поля '.$labelList['height_salon']);

                return true;
            }
        }

        return true;
    }

    public function validateMaxNumberSeats($attribute)
    {
        if (!$this->hasErrors('max_number_seats')) {

            if (intval($this->max_number_seats) <= 0 && $this->kind === self::KIND_PASSENGER) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля '.$labelList['max_number_seats'].' не може бути менше чи рівне 0, якщо значення поля '.$labelList['kind'].' дорівнює '.$this->getKindName().'.');
            }
        }
    }

    public function validateIsUnsigned($attribute)
    {
        if (!$this->hasErrors($this->$attribute)) {

            if ($this->$attribute < 0 ) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Значення поля не може бути від\'ємним.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name_type' => 'Найменування',
            'marking' => 'Позначення',
            'kind' => 'Тип навантаження',
            'length' => 'Довжина ПС(м)',
            'wingspan' => 'Розмах крил(м)',
            'wing_area' => 'Площа крил(м2)',
            'width_chassis' => 'Ширина шасі(м)',
            'length_take_off' => 'Зльотна довжина ЗПС(м)',
            'length_landing' => 'Посадочна довжина ЗПС(м)',
            'weight_empty_plane' => 'Вага ПС(кг)',
            'height_fuselage' => 'Висота фюзиляжу(м)',
            'width_fuselage' => 'Ширина  фюзиляжу(м)',
            'height_salon' => 'Висота салону(м)',
            'width_salon' => 'Ширина салону(м)',
            'max_take_off_mass' => 'Макс. злітна маса(кг)',
            'max_load' => 'Допустиме навантаження(кг)',
            'cruising_speed' => 'Крейсерська швидкість(км)',
            'max_speed' => 'Макс. швидкість(км)',
            'cruising_height' => 'Крейсерська висота(км)',
            'max_height' => 'Макс. висота(км)',
            'max_distance_empty' => 'Макс. відстань (км)',
            'distance_one_load' => 'Відст. з навантаж. 1 т.(км)',
            'max_stock_fuel' => 'Вмістм. паливного бака(л)',
            'fuel_costs_empty' => 'Розхід палива без навтж.(л)',
            'fuel_costs_unit_weight' => 'Розхід палива з навтж. 1 т.(л)',
            'max_number_seats' => 'Пасажиро-сидіння',
            'seats_business_class' => 'Місця бізнес класу',
            'count_crew' => 'Макс. число екіпажу',
            'comment' => 'Додаткова інформація',
            'created_at' => 'Дата створення запису',
            'updated_at' => 'Дата оновлення запису',
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $count = Plane::find()
                ->where(['type_id' => $this->id])
                ->count();

            if ($count > 0) {
                Yii::$app->session->setFlash('error', 'Ви не можете видалити дану модель, оскільки у БД записано наступну кількість ПК даної моделі: ' . $count . '.');
            } else {
                return true;
            }

        }

        return false;
    }

    //====================================================================================
    public function getPlane()
    {
        return $this->hasMany(Plane::className(), ['type_id' => 'id']);
    }

    //=======================================================================================
    public static function getKindList()
    {
        return [
            self::KIND_PASSENGER => 'Пасажирський',
            self::KIND_FREINHT => 'Грузовий',
        ];
    }

    public function getKindName()
    {
        return ArrayHelper::getValue(self::getKindList(), $this->kind, 'Невизначено');
    }

    public static function getAllRecordListId()
    {
        $list = (new Query())
            ->select('full_name_type')
            ->from(self::tableName())
            ->orderBy(['full_name_type' => SORT_ASC])
            ->indexBy('id')
            ->column();

        return $list;
    }
}
