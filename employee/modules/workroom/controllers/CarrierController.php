<?php

namespace employee\modules\workroom\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Carrier;
use employee\modules\workroom\models\search\CarrierSearch;

/**
 * CarrierController implements the CRUD actions for Carrier model.
 */
class CarrierController extends Controller
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
                            'view',
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
     * Lists all Carrier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarrierSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Carrier model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carrier model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Carrier();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Інформація про цього авіаперевізника була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Інформація про нового авіаперевізника під назвою \'' . $model->name . '\' була успішно збережена.');

                return $this->redirect(['index']);

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Carrier model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про цього авіаперевізника була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про авіаперевізника \''.$model->name.'\' була успішно збережена.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Carrier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $name = $model->name;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Запис про авіаперевізника з найменуванням \''.$name.'\' було успішно видалено.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carrier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carrier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
