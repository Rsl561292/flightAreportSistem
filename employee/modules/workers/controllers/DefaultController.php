<?php

namespace employee\modules\workers\controllers;

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
                            'news',
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

    /**
     * Renders the news about workers
     * @return string
     */
    public function actionNews()
    {
        return $this->render('news');
    }
}
