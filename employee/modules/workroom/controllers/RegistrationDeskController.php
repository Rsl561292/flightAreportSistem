<?php

namespace employee\modules\workroom\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\RegistrationDesk;
use employee\modules\workroom\models\search\RegistrationDeskSearch;

/**
 * RegistrationDeskController implements the CRUD actions for RegistrationDesk model.
 */
class RegistrationDeskController extends Controller
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
     * Lists all RegistrationDesk models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistrationDeskSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegistrationDesk model.
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
     * Creates a new RegistrationDesk model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistrationDesk();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Інформація про цю нову реєстраційну стійку, була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Інформація про нову реєстраційну стійку під назвою \'' . $model->symbol . '\', була успішно збережена.');

                return $this->redirect(['index']);

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RegistrationDesk model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post('continueEdit') !== null) {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про цю реєстраційну стійку була успішно збережена.');

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('success', 'Оновлена вами інформація про реєстраційну стійку \''.$model->symbol.'\', була успішно збережена.');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RegistrationDesk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $symbol = $model->symbol;

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Запис про реєстраційну стійку з позначенням \''.$symbol.'\' було успішно видалено.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the RegistrationDesk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistrationDesk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistrationDesk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрошеної сторінки не існує.');
        }
    }
}
