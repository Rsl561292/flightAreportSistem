<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_registration_desk_to_flight".
 *
 * @property integer $id
 * @property string $flight_id
 * @property string $registration_desk_id
 * @property string $class
 */
class RegistrationDeskToFlight extends \yii\db\ActiveRecord
{
    const CLASS_ECONOMIZE = '1';
    const CLASS_BUSINESS = '2';
    const CLASS_ECONOMIZE_AND_BUSINESS = '3';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%registration_desk_to_flight}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_desk_id', 'flight_id', 'class'], 'required'],
            [['flight_id', 'registration_desk_id'], 'integer'],
            ['registration_desk_id', 'validateRegistrationDesk'],
            ['flight_id', 'validateFlight'],
            ['flight_id', 'validateRegistrationDeskToFlight'],
            [['class'], 'string', 'max' => 1],
            [['class'], 'in', 'range' => array_keys(self::getClassList())],
        ];
    }

    public function validateRegistrationDesk($attribute)
    {
        if (!$this->hasErrors('registration_desk_id') && strlen($this->registration_desk_id) > 0) {

            $labelList = $this->attributeLabels();
            $model = RegistrationDesk::find()
                ->where(['id' => intval($this->registration_desk_id)])
                ->one();

            if (empty($model)) {

                $this->addError($attribute, 'Інформації про обрану вами реєстраційну стійку в полі "'.$labelList['registration_desk_id'].'" у базі даних сайту не знайдено. Будь ласка оновіть дану сторінку.');

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

            if (!($model->begin_registration_plan !== null && $model->direction === Flights::DIRECTION_FROM)) {

                $this->addError($attribute, 'Для обраного вами польоту в полі "'.$labelList['flight_id'].'" не можна задавати реєстраційну стійку для реєстрації на рейс, оскільки вибраний політ не призначений для цього.');

                return true;
            }
        }

        return true;
    }

    public function validateRegistrationDeskToFlight($attribute)
    {
        if (!$this->hasErrors('registration_desk_id') && !$this->hasErrors('flight_id')) {

            $query = self::find()
                ->where(['flight_id' => $this->flight_id])
                ->andWhere(['registration_desk_id' => $this->registration_desk_id]);

            if (!$this->isNewRecord) {
                $query->andWhere(['not', ['id' => $this->id]]);
            }

            if ($query->exists()) {

                $this->addError($attribute, 'У базі уже існує запис для вибраної вами реєстраційної стійки та польоту.');
            }
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID запис',
            'flight_id' => 'Політ',
            'registration_desk_id' => 'Реєстр. стійка',
            'class' => 'Обслуговуваний клас',
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $model = Flights::find()
                ->where(['id' => $this->flight_id])
                ->one();

            if ($model->status === Flights::STATUS_HAPPENED) {
                Yii::$app->session->setFlash('error', 'Ви не можете видалити даний запис, оскільки вибраний у цьому записі політ уже відбувся.');
            } else {
                return true;
            }

        }

        return false;
    }


    //========================================================================================
    public function getFlight()
    {
        return $this->hasOne(Flights::className(), ['id' => 'flight_id']);
    }

    public function getRegistrationDesk()
    {
        return $this->hasOne(RegistrationDesk::className(), ['id' => 'registration_desk_id']);
    }

    //=====================================================================================
    public static function getClassList()
    {
        return [
            self::CLASS_ECONOMIZE => 'Економ',
            self::CLASS_BUSINESS => 'Бізнес',
            self::CLASS_ECONOMIZE_AND_BUSINESS => 'Бізнес та економ',
        ];
    }

    public function getClassName()
    {
        return ArrayHelper::getValue(self::getClassList(), $this->class, 'Невизначено');
    }
}
