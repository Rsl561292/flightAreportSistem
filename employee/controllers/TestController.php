<?php
namespace employee\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\GisCountry;
use common\models\GisRegions;
use employee\models\PasswordResetRequestForm;
use employee\models\ResetPasswordForm;
use employee\models\SignupForm;

/**
 * Test controller
 */
class TestController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $country = 235;
        $listRegions = GisRegions::getActiveRegionsListByCountryOnId($country);
        $list = [];

        if (!empty($listRegions)) {
            foreach ($listRegions as $key => $val) {
                $list[] = [$key, Html::decode($val)];
            }
        }

        echo '<pre>';
        print_r($list);
        echo '<pre>';

        return false;

    }

}
