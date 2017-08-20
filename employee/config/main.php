<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$employeeRules = require(__DIR__ . '/urls.php');

return [
    'id' => 'app-employee',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'employee\controllers',
    'aliases' => [
        '@adminlte/widgets'=>'@vendor/adminlte/yii2-widgets'
    ],
    'modules' => [
        'workers' => [
            'class' => 'employee\modules\workers\Module',
        ],
        'workroom' => [
            'class' => 'employee\modules\workroom\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-employee',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-employee', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the employee
            'name' => 'advanced-employee',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $employeeRules,
        ],
    ],
    'params' => $params,
];
