<?php

namespace employee\modules\workroom\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\GisCountry;
use common\models\GisRegions;
use employee\modules\workroom\models\search\RegionsSearch;

/**
 * RegionsController implements the CRUD actions for GisRegions model.
 */
class RegionsController extends Controller
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
                            'create',
                            'update',
                            'delete',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all GisRegions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegionsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GisRegions model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GisRegions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Інформація про цей новий штат/регіон/обл., була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                $country = GisCountry::find()
                    ->where(['id' => $model->country_id])
                    ->one();

                Yii::$app->session->setFlash('success', 'Інформація про новий штат/регіон/обл. під найменуванням \'' . $model->name . '\', країни \'' . $country['name'] . '\', була успішно збережена.');

                return $this->redirect(['index']);

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GisRegions model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про цей новий штат/регіон/обл. була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                $country = GisCountry::find()
                    ->where(['id' => $model->country_id])
                    ->one();

                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про штат/регіон/обл. під найменуванням \'' . $model->name . '\', країни \'' . $country['name'] . '\', була успішно збережена.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GisRegions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $nameRegion = $model->name;
        $countryId = $model->country_id;

        if ($model->delete()) {
            $country = GisCountry::find()
                ->where(['id' => $countryId])
                ->one();

            Yii::$app->session->setFlash('success', 'Запис про штат/регіон/обл. під найменуванням \'' . $nameRegion . '\', країни \'' . $country['name'] . '\' було успішно видалено.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the GisRegions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GisRegions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GisRegions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
