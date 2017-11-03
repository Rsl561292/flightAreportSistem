<?php

namespace employee\modules\workroom\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\RegistrationDeskToFlight;
use employee\modules\workroom\models\search\RegistrationDeskToFlightSearch;

/**
 * RegistrationDeskToFlightController implements the CRUD actions for RegistrationDeskToFlight model.
 */
class RegistrationDeskToFlightController extends Controller
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
     * Lists all RegistrationDeskToFlight models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistrationDeskToFlightSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RegistrationDeskToFlight model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistrationDeskToFlight();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Даний запис успішно збережено. Ви можете приступити до його редагування.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Нова інформація про те яку реєстраційну стійку в якому польоті використовується була успішно збережена під кодом запису \'' . $model->id . '\',.');

                return $this->redirect(['index']);

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RegistrationDeskToFlight model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Внесені вами зміни у цьому записі були успішно збережені.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Внесені вами зміни у записі під кодом запису \''.$model->id.'\', були успішно збережені.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RegistrationDeskToFlight model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $zm = $model->id;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Запис, що зберігався під кодом \''.$zm.'\' було успішно видалено.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the RegistrationDeskToFlight model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistrationDeskToFlight the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistrationDeskToFlight::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запитуваного запису не існує.');
        }
    }
}
