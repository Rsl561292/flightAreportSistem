<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_schedule_busy_platform".
 *
 * @property integer $id
 * @property string $platform_id
 * @property string $plane_id
 * @property string $flight_id
 * @property string $status
 * @property string $begin_busy_plan
 * @property string $end_busy_plan
 * @property string $begin_busy_fact
 * @property string $end_busy_fact
 */
class ScheduleBusyPlatform extends \yii\db\ActiveRecord
{
    const STATUS_SCHEDULED = '1';
    const STATUS_USED = '2';
    const STATUS_COMPLETED = '3';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_busy_platform}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'plane_id', 'begin_busy_plan', 'end_busy_plan', 'status'], 'required'],
            [['platform_id', 'plane_id', 'flight_id'], 'integer'],
            ['platform_id', 'validatePlatform'],
            ['plane_id', 'validatePlane'],
            ['flight_id', 'validateFlight'],
            [['begin_busy_plan', 'end_busy_plan', 'begin_busy_fact', 'end_busy_fact'], 'safe'],
            ['begin_busy_plan', 'validateBeginBusyPlan'],
            ['begin_busy_fact', 'validateBeginBusyFact'],
            [['status'], 'string', 'max' => 1],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
        ];
    }

    public function validateBeginBusyPlan($attribute)
    {
        if (!$this->hasErrors('begin_busy_plan')) {

            $labelList = $this->attributeLabels();

            if (!$this->hasErrors('end_busy_plan')) {

                if ((strlen($this->end_busy_plan) !== 0) && (strtotime($this->begin_busy_plan) >= strtotime($this->end_busy_plan))) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_busy_plan'].', то значення поля '.$labelList['begin_busy_plan'].' має бути задано та бути менше значення поля '.$labelList['end_busy_plan'].'.');

                    return true;
                }
            }

        }

        return true;
    }

    public function validateBeginBusyFact($attribute)
    {
        if (!$this->hasErrors('begin_busy_fact')) {

            $labelList = $this->attributeLabels();

            if (!$this->hasErrors('end_busy_fact')) {

                if ((strlen($this->begin_busy_fact) === 0) && (strlen($this->end_busy_fact) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_busy_fact'].', то має бути задано і значення поля '.$labelList['begin_busy_fact'].'.');

                    return true;
                }

                if ((strlen($this->end_busy_fact) !== 0) && (strtotime($this->begin_busy_fact) >= strtotime($this->end_busy_fact))) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['end_busy_fact'].', то значення поля '.$labelList['begin_busy_fact'].' має бути задано та бути менше значення поля '.$labelList['end_busy_fact'].'.');

                    return true;
                }

                if ((strlen($this->end_busy_fact) === 0) && (strlen($this->begin_busy_fact) !== 0)) {

                    $this->addError($attribute, 'Якщо задано значення поля '.$labelList['begin_busy_fact'].', то значення поля '.$labelList['end_busy_fact'].' має бути задано та бути більше значення поля '.$labelList['begin_busy_fact'].'.');

                    return true;
                }
            }

        }

        return true;
    }

    public function validatePlatform($attribute)
    {
        if (!$this->hasErrors('platform_id') && strlen($this->platform_id) > 0) {

            $labelList = $this->attributeLabels();
            $model = Platform::find()
                ->where(['id' => intval($this->platform_id)])
                ->one();

            if (empty($model)) {

                $this->addError($attribute, 'Інформації про обраний вами перон в полі "'.$labelList['platform_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

                return true;
            }

        }

        return true;
    }

    public function validatePlane($attribute)
    {
        if (!$this->hasErrors('plane_id') && strlen($this->plane_id) > 0) {

            $labelList = $this->attributeLabels();
            $model = Plane::find()
                ->where(['id' => intval($this->plane_id)])
                ->one();

            if (empty($model)) {

                $this->addError($attribute, 'Інформації про обране вами ПС в полі "'.$labelList['plane_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

                return true;
            }

        }

        return true;
    }

    public function validateFlight($attribute)
    {
        if (!$this->hasErrors('flight_id') && strlen($this->flight_id) > 0) {

            $labelList = $this->attributeLabels();
            $model = Flights::find()
                ->where(['id' => intval($this->flight_id)])
                ->one();

            if (empty($model)) {

                $this->addError($attribute, 'Інформації про обраний вами політ в полі "'.$labelList['flight_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

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
            'platform_id' => 'Перон',
            'plane_id' => 'Повітряне судно',
            'flight_id' => 'Політ',
            'status' => 'Статус',
            'begin_busy_plan' => 'Початок використання(пл.)',
            'end_busy_plan' => 'Завершити використання(пл.)',
            'begin_busy_fact' => 'Почато використання',
            'end_busy_fact' => 'Завершено використання',
        ];
    }

    public function init()
    {
        parent::init();

        $this->status = self::STATUS_SCHEDULED;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            return true;
        }

        return false;
    }

    //========================================================================================
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform_id']);
    }

    public function getPlane()
    {
        return $this->hasOne(Plane::className(), ['id' => 'plane_id']);
    }

    public function getFlight()
    {
        return $this->hasOne(Flights::className(), ['id' => 'flight_id']);
    }

    //=====================================================================================
    public static function getStatusList()
    {
        return [
            self::STATUS_SCHEDULED => 'Заплановано',
            self::STATUS_USED => 'Використовується',
            self::STATUS_COMPLETED => 'Завершено',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }

}
