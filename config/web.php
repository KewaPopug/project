<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
//            'controllerMap' => [
//                'assignment' => [
//                    'class' => 'mdm\admin\controllers\AssignmentController',
//                    'userClassName' => 'app\models\User',
//                    'idField' => 'id',
//                    'usernameField' => 'username',
////                    'fullnameField' => 'profile.full_name',
////                    'extraColumns' => [
////                        [
////                            'attribute' => 'full_name',
////                            'label' => 'Full Name',
////                            'value' => function($model, $key, $index, $column) {
////                                return $model->profile->full_name;
////                            },
////                        ],
//////                        [
//////                            'attribute' => 'dept_name',
//////                            'label' => 'Department',
//////                            'value' => function($model, $key, $index, $column) {
//////                                return $model->profile->dept->name;
//////                            },
//////                        ],
//////                        [
//////                            'attribute' => 'post_name',
//////                            'label' => 'Post',
//////                            'value' => function($model, $key, $index, $column) {
//////                                return $model->profile->post->name;
//////                            },
//////                        ],
////                    ],
////                    'searchClass' => 'app\models\UserSearch'
//                ],
//            ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yYy4YYYX8lYyYyQOl8vOcO6ROo7i8twO',
            'baseUrl' => ''
        ],
//               'request' => [
//            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
//            'cookieValidationKey' => 'RHOkwBKMYXd-UCt7PiO3HDsJc4-KQTH-',
//        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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

        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['admin', 'user'], // Здесь нет роли "guest", т.к. эта роль виртуальная и не присутствует в модели UserExt
            // or use 'yii\rbac\DbManager'
        ],
//        'authManager' => [
//            'class' => 'yii\rbac\DbManager',
//            // uncomment if you want to cache RBAC items hierarchy
//            // 'cache' => 'cache',
//        ]
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '/*',
            '/login',
//            'user/*',
//            'site/*',
//            'admin/*',
//            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}


return $config;
