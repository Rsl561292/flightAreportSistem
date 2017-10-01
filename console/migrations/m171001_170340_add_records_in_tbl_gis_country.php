<?php

use yii\db\Migration;
use common\models\GisCountry;

class m171001_170340_add_records_in_tbl_gis_country extends Migration
{
    public function safeUp()
    {
        $listCountrySave = [];
        $listCountrySlug = array_flip(Yii::$app->params['countrySlugList']);

        if (count($listCountrySlug) === count(Yii::$app->params['countryCodeList'])) {

            foreach(Yii::$app->params['countryCodeList'] as $key => $value) {

                $listCountrySave[$key] = [
                    $key,
                    $value,
                    $listCountrySlug[$key],
                    GisCountry::STATUS_ACTIVE,
                ];
            }

            Yii::$app->db->createCommand()->batchInsert(GisCountry::tableName(), [
                'code',
                'name',
                'slug',
                'status'
            ], $listCountrySave)->execute();
        }
    }

    public function safeDown()
    {
        $this->delete(GisCountry::tableName());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171001_170340_add_records_in_tbl_gis_country cannot be reverted.\n";

        return false;
    }
    */
}
