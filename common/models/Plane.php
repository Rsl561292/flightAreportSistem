<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_plane".
 *
 * @property integer $id
 * @property string $type_id
 * @property string $registration_code
 * @property string $carrier_id
 * @property string $status_location
 * @property string $status_preparation
 */
class Plane extends \yii\db\ActiveRecord
{
    const STATUS_LOCATION_IN_AREPORT = '1';
    const STATUS_LOCATION_NOT_IN_AREPORT = '2';

    const STATUS_PREPARATION_IN_WORKING = '1';
    const STATUS_PREPARATION_NEED_REPAIR = '2';
    const STATUS_PREPARATION_NEED_TECHNICAL_CHECK = '3';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plane}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'registration_code',
                    'type_id', 'carrier_id',
                    'status_location', 'status_preparation'
                ],
                'required'
            ],
            [['registration_code'], 'string', 'max' => 20],
            [['registration_code'], 'unique'],
            [['type_id', 'carrier_id'], 'integer'],
            ['type_id', 'validateIsTypeInDatabase'],
            ['carrier_id', 'validateIsCarrierInDatabase'],
            [['status_location'], 'string', 'max' => 1],
            [['status_location'], 'in', 'range' => array_keys(self::getStatusLocationList())],
            [['status_preparation'], 'string', 'max' => 2],
            [['status_preparation'], 'in', 'range' => array_keys(self::getStatusPreparationList())],
        ];
    }

    public function validateIsTypeInDatabase($attribute)
    {
        if (!$this->hasErrors('type_id')) {

            if (!TypesPlanes::find()->where(['id' => $this->type_id])->exists()) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Вибраного вами значення в полі '.$labelList['type_id'].' уже не існує в базі даних системи. Обновіть сторінку щоб отримати доступ до актуальніших даних');
            }
        }
    }

    public function validateIsCarrierInDatabase($attribute)
    {
        if (!$this->hasErrors('carrier_id')) {

            if (!Carrier::find()->where(['id' => $this->carrier_id])->exists()) {
                $labelList = $this->attributeLabels();

                $this->addError($attribute, 'Вибраного вами значення в полі '.$labelList['carrier_id'].' уже не існує в базі даних системи. Обновіть сторінку щоб отримати доступ до актуальніших даних');
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
            'type_id' => 'Модель',
            'registration_code' => 'Бортовий номер ПС',
            'carrier_id' => 'Власник ПС',
            'status_location' => 'Розташування',
            'status_preparation' => 'Тех. стан',
        ];
    }

    public function getType()
    {
        return $this->hasOne(TypesPlanes::className(), ['id' => 'type_id']);
    }

    public function getCarrier()
    {
        return $this->hasOne(Carrier::className(), ['id' => 'carrier_id']);
    }

    public static function getStatusLocationList()
    {
        return [
            self::STATUS_LOCATION_IN_AREPORT => 'В аеропорті',
            self::STATUS_LOCATION_NOT_IN_AREPORT => 'Не в аеропорті',
        ];
    }

    public function getStatusLocationName()
    {
        return ArrayHelper::getValue(self::getStatusLocationList(), $this->status_location, 'Невизначено');
    }

    public static function getStatusPreparationList()
    {
        return [
            self::STATUS_PREPARATION_IN_WORKING => 'В робочому',
            self::STATUS_PREPARATION_NEED_REPAIR => 'Потребує ремонту',
            self::STATUS_PREPARATION_NEED_TECHNICAL_CHECK => 'Потребує технічного огляду',
        ];
    }

    public function getStatusPreparationName()
    {
        return ArrayHelper::getValue(self::getStatusPreparationList(), $this->status_preparation, 'Невизначено');
    }
}
