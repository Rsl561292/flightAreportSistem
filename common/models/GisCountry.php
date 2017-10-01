<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_gis_country".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property string $status
 */
class GisCountry extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '2';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gis_country}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'slug'], 'required'],
            [['code'], 'string', 'max' => 32],
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['code'], 'unique'],
            ['status', 'default' => '1']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Назва',
            'slug' => 'Слаг',
            'status' => 'Статус',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активний',
            self::STATUS_INACTIVE => 'Не активний'
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, 'Невизначено');
    }

}
