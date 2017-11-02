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
    const STATUS_CANCELED = '4';

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
            [['status'], 'string', 'max' => 1],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],
            ['status', 'validateStatus'],
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

                if ($this->status == self::STATUS_SCHEDULED || ($this->isNewRecord && $this->status == self::STATUS_USED)) {
                    //перевірка чи плановий інтервал не перекривається іншими плановими
                    $query = self::find()
                        ->with([
                            'plane',
                        ])
                        ->where(['platform_id' => $this->platform_id])
                        ->andWhere(['or',
                            ['and',
                                ['<=', 'begin_busy_plan', $this->begin_busy_plan],
                                ['>=', 'end_busy_plan', $this->begin_busy_plan]
                            ],
                            ['and',
                                ['<=', 'begin_busy_plan', $this->end_busy_plan],
                                ['>=', 'end_busy_plan', $this->end_busy_plan]
                            ],
                            ['and',
                                ['>=', 'begin_busy_plan', $this->begin_busy_plan],
                                ['<=', 'end_busy_plan', $this->end_busy_plan]
                            ]
                        ])
                        ->andWhere(['status' => self::STATUS_SCHEDULED]);

                    if (!$this->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->id]]);
                    }

                    $listRecord = $query->all();

                    if (count($listRecord) > 0) {
                        $text = 'Вказаний вами інтервал зайнятості даного перону по плану уже перекриває наступними запланованими інтервалами зайнятості даного перону:  ';
                        $index = 1;

                        foreach ($listRecord as $record) {
                            $text .= $index.') з '.date('Y-m-d H:i', strtotime($record->begin_busy_plan)).' по '.date('Y-m-d H:i', strtotime($record->end_busy_plan)).' для ПС з бортовим кодом \''.$record->plane->registration_code.'\', код запису якого '.$record->id.'|  ';
                            $index++;
                        }

                        $this->addError($attribute, $text);

                        return true;
                    }

                    //перевірка чи плановий інтервал не перекривається іншими фактичними
                    $query = self::find()
                        ->with([
                            'plane',
                        ])
                        ->where(['platform_id' => $this->platform_id])
                        ->andWhere(['or',
                            ['and',
                                ['<=', 'begin_busy_fact', $this->begin_busy_plan],
                                ['>=', 'end_busy_fact', $this->begin_busy_plan]
                            ],
                            ['and',
                                ['<=', 'begin_busy_fact', $this->end_busy_plan],
                                ['>=', 'end_busy_fact', $this->end_busy_plan]
                            ],
                            ['and',
                                ['>=', 'begin_busy_fact', $this->begin_busy_plan],
                                ['<=', 'end_busy_fact', $this->end_busy_plan]
                            ]
                        ])
                        ->andWhere(['status' => self::STATUS_COMPLETED]);

                    if (!$this->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->id]]);
                    }

                    $listRecord = $query->all();

                    if (count($listRecord) > 0) {
                        $text = 'Вказаний вами інтервал зайнятості даного перону по плану уже перекриває наступними інтервалами фактичної зайнятості даного перону:  ';
                        $index = 1;

                        foreach ($listRecord as $record) {
                            $text .= $index.') з '.date('Y-m-d H:i', strtotime($record->begin_busy_fact)).' по '.date('Y-m-d H:i', strtotime($record->end_busy_fact)).' для ПС з бортовим кодом \''.$record->plane->registration_code.'\''.', код запису якого '.$record->id.'|  ';
                            $index++;
                        }

                        $this->addError($attribute, $text);

                        return true;
                    }
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

    public function validateStatus($attribute)
    {
        if (!$this->hasErrors('status')) {

            if ($this->status === self::STATUS_USED) {

                $query = self::find()
                    ->where(['platform_id' => $this->platform_id])
                    ->andWhere(['status' => self::STATUS_USED]);

                if (!$this->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->id]]);
                }

                $model = $query->one();

                if (!empty($model)) {

                    $this->addError($attribute, 'Ви не можете перевести даний запис про час займання для вибраного перону у статус \''.$this->getStatusName().'\', оскільки зараз є інший запис для даного перону, який вже перебуває у статусі \''.$this->getStatusName().'\'. Код цього запису - '.$model->id);

                    return true;
                }
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

            switch ($this->status) {
                case self::STATUS_SCHEDULED:
                    $this->begin_busy_fact = null;
                    $this->end_busy_fact = null;

                    break;

                case self::STATUS_USED:
                    $this->begin_busy_fact = date('Y-m-d H:i:s');
                    $this->end_busy_fact = null;

                    break;

                case self::STATUS_COMPLETED:
                    if ($this->begin_busy_fact == null) {

                        $this->begin_busy_fact = date('Y-m-d H:i:s');
                    }

                    $this->end_busy_fact = date('Y-m-d H:i:s');

                    break;

                case self::STATUS_CANCELED:
                    $this->begin_busy_fact = null;
                    $this->end_busy_fact = null;

                    break;
            }

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
            self::STATUS_CANCELED => 'Відмінено'
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }

}
