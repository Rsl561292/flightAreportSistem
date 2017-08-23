<?php

namespace employee\modules\workroom\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `workers` module
 */
class DefaultController extends Controller
{
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
                            'setting-profile',
                            'setting-system',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSettingProfile()
    {
        return $this->render('setting-profile');
    }

    public function actionSettingSystem()
    {
        return $this->render('setting-system');
    }
}
