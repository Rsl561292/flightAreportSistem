<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_terminals".
 *
 * @property integer $id
 * @property string $name
 * @property string $symbol
 * @property string $year_built
 * @property string $status
 * @property double $area
 * @property string $description
 */
class Terminals extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = '1'; // відкрити
    const STATUS_CLOSE = '2'; // повністю закритий
    const STATUS_RECONSTRUCTION = '3'; // закритий на ремонтні роботи

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%terminals}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['symbol', 'status'], 'required'],
            [['area'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['symbol', 'status'], 'string', 'max' => 2],
            ['year_built', 'date', 'format' => 'yyyy-mm-dd'],
            [['symbol'], 'unique'],
            ['year_built', 'validateYearBuilt'],
        ];
    }

    public function validateYearBuilt($attribute,$params)
    {
        if(strtotime($this->$attribute) > mktime(0,0,0)){
            $this->addError($attribute,'Дата побудови не може бути майбутньою.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код запису',
            'name' => 'Найменування',
            'symbol' => 'Позначення',
            'year_built' => 'Рік побудови',
            'status' => 'Статус',
            'area' => 'Площа',
            'description' => 'Опис',
        ];
    }

    public function getRegistrationDesk()
    {
        return $this->hasMany(RegistrationDesk::className(), ['terminal_id' => 'id']);
    }

    public function getPlatform()
    {
        return $this->hasMany(Platform::className(), ['terminal_id' => 'id']);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_OPEN => 'Відкритий',
            self::STATUS_CLOSE => 'Закритий',
            self::STATUS_RECONSTRUCTION => 'Реконструкція',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }

    public static function getTerminalsListAll()
    {
        $list = self::find()
            ->select('name')
            ->orderBy(['id' => SORT_ASC])
            ->indexBy('id')
            ->column();

        return $list;
    }
}
