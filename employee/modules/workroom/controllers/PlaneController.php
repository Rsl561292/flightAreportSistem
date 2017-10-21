<?php

namespace employee\modules\workroom\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Plane;
use employee\modules\workroom\models\search\PlaneSearch;

/**
 * PlaneController implements the CRUD actions for Plane model.
 */
class PlaneController extends Controller
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
     * Lists all Plane models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaneSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plane model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Plane::find()
            ->with([
                'type',
                'carrier',
            ])
            ->where(['id' => $id])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException('Запрошувана сторінка не існує.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Plane model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plane();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Інформація про це ПС була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Інформація про нове ПС під кодом реєстрації \'' . $model->registration_code . '\' була успішно збережена.');

                return $this->redirect(['index']);

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Plane model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про це ПС була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про ПС \''.$model->registration_code.'\' була успішно збережена.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Plane model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $name = $model->registration_code;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Запис про ПС з реєстраційним кодом \''.$name.'\' було успішно видалено.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Plane model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plane the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plane::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
