<?php

namespace employee\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use common\models\GisRegions;

class GeoController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-country-list' => ['get'],
                    'get-regions-list-by-country' => ['get'],
                ],
            ],
        ];
    }

    public function actionGetRegionsListByCountry()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(405, 'Method not allowed.');
        }

        $country = Yii::$app->request->get('country');
        $listRegions = GisRegions::getActiveRegionsListByCountryOnId($country);
        $list = [];

        if (!empty($listRegions)) {
            foreach ($listRegions as $key => $val) {
                $list[] = [$key, Html::decode($val)];
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $list;
    }

}
