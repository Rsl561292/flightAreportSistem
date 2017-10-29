<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_flights".
 *
 * @property integer $id
 * @property string $type
 * @property string $direction
 * @property string $datetime_plane
 * @property string $datetime_fact
 * @property string $plane_id
 * @property string $strip_id
 * @property string $status
 * @property string $visible
 * @property string $airport_id
 * @property string $begin_registration_plan
 * @property string $end_registration_plan
 * @property string $begin_registration_fact
 * @property string $end_registration_fact
 * @property string $begin_landing_plan
 * @property string $end_landing_plan
 * @property string $begin_landing_fact
 * @property string $end_landing_fact
 */
class Flights extends \yii\db\ActiveRecord
{
    const TYPE_FREIGHT = '1';
    const TYPE_PASSENGER = '2';

    const DIRECTION_FROM = '1';
    const DIRECTION_IN = '2';

    const STATUS_EXPECTED = '1';
    const STATUS_HAPPENED = '2';

    const VISIBLE_ALL = '1';
    const VISIBLE_ONLY_EMPLOYEES = '2';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flights}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'datetime_plane',
                    'plane_id',
                    'strip_id',
                    'type',
                    'direction',
                    'status',
                    'visible'
                ], 'required'
            ],
            [
                [
                    'datetime_plane',
                    'datetime_fact',
                    'begin_registration_plan',
                    'end_registration_plan',
                    'begin_registration_fact',
                    'end_registration_fact',
                    'begin_landing_plan',
                    'end_landing_plan',
                    'begin_landing_fact',
                    'end_landing_fact'
                ], 'safe'
            ],
            ['begin_registration_plan', 'validateBeginRegistrationPlan'],
            ['begin_registration_fact', 'validateBeginRegistrationFact'],
            ['begin_landing_plan', 'validateBeginLandingPlan'],
            ['begin_landing_fact', 'validateBeginLandingFact'],
            [['plane_id', 'strip_id', 'airport_id'], 'integer'],
            ['plane_id', 'validatePlane'],
            ['strip_id', 'validateStrip'],
            ['airport_id', 'validateAirport'],
            [['type', 'direction', 'status', 'visible'], 'string', 'max' => 1],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],
            ['direction', 'in', 'range' => array_keys(self::getDirectionList())],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            ['visible', 'in', 'range' => array_keys(self::getVisibleList())]
        ];
    }

    public function validateBeginRegistrationPlan($attribute)
    {
        if (!$this->hasErrors('begin_registration_plan')) {

            $labelList = $this->attributeLabels();

            if (!$this->hasErrors('end_registration_plan')) {

                if ((strlen($this->end_registration_plan) !== 0) && (strlen($this->begin_registration_plan) === 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_registration_plan'].', то має бути задано і значення поля '.$labelList['begin_registration_plan'].'.');

                    return true;
                }

                if ((strlen($this->end_registration_plan) !== 0) && (strtotime($this->begin_registration_plan) >= strtotime($this->end_registration_plan))) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_registration_plan'].', то значення поля '.$labelList['begin_registration_plan'].' має бути задано та бути менше значення поля '.$labelList['end_registration_plan'].'.');

                    return true;
                }

                if ((strlen($this->end_registration_plan) === 0) && (strlen($this->begin_registration_plan) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['begin_registration_plan'].', то значення поля '.$labelList['end_registration_plan'].' має бути задано та бути більше значення поля '.$labelList['begin_registration_plan'].'.');

                    return true;
                }
            }

        }

        return true;
    }

    public function validateBeginRegistrationFact($attribute)
    {
        if (!$this->hasErrors('begin_registration_fact')) {

            $labelList = $this->attributeLabels();

            if (!$this->hasErrors('end_registration_fact')) {

                if ((strlen($this->begin_registration_fact) === 0) && (strlen($this->end_registration_fact) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_registration_fact'].', то має бути задано і значення поля '.$labelList['begin_registration_fact'].'.');

                    return true;
                }

                if ((strlen($this->end_registration_fact) !== 0) && (strtotime($this->begin_registration_fact) >= strtotime($this->end_registration_fact))) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_registration_fact'].', то значення поля '.$labelList['begin_registration_fact'].' має бути задано та бути менше значення поля '.$labelList['end_registration_fact'].'.');

                    return true;
                }

                if ((strlen($this->end_registration_fact) === 0) && (strlen($this->begin_registration_fact) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['begin_registration_fact'].', то значення поля '.$labelList['end_registration_fact'].' має бути задано та бути більше значення поля '.$labelList['begin_registration_fact'].'.');

                    return true;
                }
            }

        }

        return true;
    }

    public function validateBeginLandingPlan($attribute)
    {
        if (!$this->hasErrors('begin_landing_plan')) {

            $labelList = $this->attributeLabels();

            if (!$this->hasErrors('end_landing_plan')) {

                if ((strlen($this->begin_landing_plan) == 0) && (strlen($this->end_landing_plan) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_landing_plan'].', то має бути задано і значення поля '.$labelList['begin_landing_plan'].'.');

                    return true;
                }

                if ((strlen($this->end_landing_plan) !== 0) && (strtotime($this->begin_landing_plan) >= strtotime($this->end_landing_plan))) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_landing_plan'].', то значення поля '.$labelList['begin_landing_plan'].' має бути задано та бути менше значення поля '.$labelList['end_landing_plan'].'.');

                    return true;
                }

                if ((strlen($this->end_landing_plan) === 0) && (strlen($this->begin_landing_plan) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['begin_landing_plan'].', то значення поля '.$labelList['end_landing_plan'].' має бути задано та бути більше значення поля '.$labelList['begin_landing_plan'].'.');

                    return true;
                }
            }

        }

        return true;
    }

    public function validateBeginLandingFact($attribute)
    {
        if (!$this->hasErrors('begin_landing_fact')) {

            $labelList = $this->attributeLabels();

            if (!$this->hasErrors('end_landing_fact')) {

                if ((strlen($this->begin_landing_fact) === 0) && (strlen($this->end_landing_fact) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_landing_fact'].', то має бути задано і значення поля '.$labelList['begin_landing_fact'].'.');

                    return true;
                }

                if ((strlen($this->end_landing_fact) !== 0) && (strtotime($this->begin_landing_fact) >= strtotime($this->end_landing_fact))) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_landing_fact'].', то значення поля '.$labelList['begin_landing_fact'].' має бути задано та бути менше значення поля '.$labelList['end_landing_fact'].'.');

                    return true;
                }

                if ((strlen($this->end_landing_fact) === 0) && (strlen($this->begin_landing_fact) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['begin_landing_fact'].', то значення поля '.$labelList['end_landing_fact'].' має бути задано та бути більше значення поля '.$labelList['begin_landing_fact'].'.');

                    return true;
                }
            }

        }

        return true;
    }

    public function validatePlane($attribute)
    {
        if (!$this->hasErrors('plane_id')) {

            $labelList = $this->attributeLabels();
            $modelPlane = Plane::find()
                ->with([
                    'type'
                ])
                ->where(['id' => intval($this->plane_id)])
                ->one();

            if (!empty($modelPlane)) {

                if (!$this->hasErrors('direction') && !$this->hasErrors('strip_id')) {

                    $modelStrip = FlightStrips::findOne(intval($this->strip_id));

                    if (($this->direction == self::DIRECTION_FROM) && ($modelPlane->type->length_take_off > ($modelStrip->length_NDR + $modelStrip->length_VZ))) {

                        $this->addError($attribute, 'Вибране вами ПС в полі "'.$labelList['plane_id'].'" не може здійснити зліт на вибраній ЗПС в полі "'.$labelList['strip_id'].'", оскільки вибране ПС потребує більшої довжини ЗПС для зльоту ніж довжина НДЗ вибраної вами ЗПС.');

                        return true;
                    }

                    if (($this->direction == self::DIRECTION_IN) && ($modelPlane->type->length_landing > ($modelStrip->length_NDR - $modelStrip->bias_threshold))) {

                        $this->addError($attribute, 'Вибране вами ПС в полі "'.$labelList['plane_id'].'" не може здійснити посадку на вибраній ЗПС в полі "'.$labelList['strip_id'].'", оскільки вибране ПС потребує більшої довжини ЗПС для посадки ніж довжина НПД вибраної вами ЗПС.');

                        return true;
                    }

                    if ((36*log10($modelPlane->type->wingspan) + $modelPlane->type->width_chassis + 10) > $modelStrip->width) {

                        $this->addError($attribute, 'Вибране вами ПС в полі "'.$labelList['plane_id'].'" не може здійснити посадку/зліт на вибраній ЗПС в полі "'.$labelList['strip_id'].'", оскільки вибране ПС потребує більшої ширини ЗПС для посадки/зльоту ніж ширина вибраної вами ЗПС.');

                        return true;
                    }
                }
            } else {
                $this->addError($attribute, 'Інформації про обране вами ПС в полі "'.$labelList['plane_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

                return true;
            }

        }

        return true;
    }

    public function validateStrip($attribute)
    {
        if (!$this->hasErrors('strip_id') && strlen($this->strip_id) > 0) {

            $labelList = $this->attributeLabels();
            $model = FlightStrips::find()
                ->where(['id' => intval($this->strip_id)])
                ->one();

            if (empty($model)) {

                $this->addError($attribute, 'Інформації про обрану вами ЗПС в полі "'.$labelList['strip_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

                return true;
            }

        }

        return true;
    }

    public function validateAirport($attribute)
    {
        if (!$this->hasErrors('airport_id') && strlen($this->airport_id) > 0) {

            $labelList = $this->attributeLabels();
            $model = Airports::find()
                ->where(['id' => intval($this->airport_id)])
                ->one();

            if (empty($model)) {

                $this->addError($attribute, 'Інформації про обраний вами аеропорт в полі "'.$labelList['airport_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

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
            'id' => 'ID запису',
            'type' => 'Тип перевезень',
            'direction' => 'Напрям',
            'datetime_plane' => 'Час вильоту/посадки(пл.)',
            'datetime_fact' => 'Час вильоту/посадки(фк.)',
            'plane_id' => 'Повітряне судно',
            'strip_id' => 'Використовувана ЗПС',
            'status' => 'Статус',
            'visible' => 'Видимість',
            'airport_id' => 'Аеропорт',
            'begin_registration_plan' => 'Початок реєстрації(пл.)',
            'end_registration_plan' => 'Закінчення реєстрації(пл.)',
            'begin_registration_fact' => 'Початок реєстрації(фк.)',
            'end_registration_fact' => 'Закінчення реєстрації(фк.)',
            'begin_landing_plan' => 'Початок посадки(пл.)',
            'end_landing_plan' => 'Закінчення посадки(пл.)',
            'begin_landing_fact' => 'Початок посадки(фк.)',
            'end_landing_fact' => 'Закінчення посадки(фк.)',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if(strlen($this->datetime_fact) == 0) {

                $this->datetime_fact = $this->datetime_plane;
            }

            return true;
        }

        return false;
    }

    //========================================================================================
    public function getPlane()
    {
        return $this->hasOne(Plane::className(), ['id' => 'plane_id']);
    }

    public function getStrip()
    {
        return $this->hasOne(FlightStrips::className(), ['id' => 'strip_id']);
    }

    public function getAirport()
    {
        return $this->hasOne(Airports::className(), ['id' => 'airport_id']);
    }

    //=====================================================================================
    public static function getTypeList()
    {
        return [
            self::TYPE_FREIGHT => 'Вантажне',
            self::TYPE_PASSENGER => 'Пасажирське',
        ];
    }

    public function getTypeName()
    {
        return ArrayHelper::getValue(self::getTypeList(), $this->type, 'Невизначено');
    }

    public static function getDirectionList()
    {
        return [
            self::DIRECTION_FROM => 'З аеропорту',
            self::DIRECTION_IN => 'В аеропорт',
        ];
    }

    public function getDirectionName()
    {
        return ArrayHelper::getValue(self::getDirectionList(), $this->direction, 'Невизначено');
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_EXPECTED => 'Очікується',
            self::STATUS_HAPPENED => 'Відбувся',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }

    public static function getVisibleList()
    {
        return [
            self::VISIBLE_ALL => 'Для всіх',
            self::VISIBLE_ONLY_EMPLOYEES => 'Тільки працівникам',
        ];
    }

    public function getVisibleName()
    {
        return ArrayHelper::getValue(self::getVisibleList(), $this->visible, 'Невизначено');
    }

}
