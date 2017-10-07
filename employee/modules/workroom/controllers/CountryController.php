<?php

namespace employee\modules\workroom\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\GisCountry;
use employee\modules\workroom\models\search\CountriesSearch;

/**
 * CountryController implements the CRUD actions for GisCountry model.
 */
class CountryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'update-status',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update-status' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all GisCountry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountriesSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the GisCountry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GisCountry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GisCountry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateStatus()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException(405, 'Method not allowed.');
        }

        $response = false;

        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');

        if ($id !== null && $status !== null) {
            $model = GisCountry::findOne(intval($id));

            if ($model !== null) {
                $model->status = $status;

                $response = $model->save();
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ['response' => $response];
    }
}
