<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                // [
                //     'class' => 'yii\rest\UrlRule', 
                //     'controller' => 'v1/test',
                //     'extraPatterns' => [
                //         'POST login' => 'login',
                //         'POST getusers' => 'getusers'
                //     ],
                //     'tokens' => [
                //         '{id}' => '<id:\\w+>'
                //     ],
                // ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/login',
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST getusers' => 'getusers'
                        
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                ],
                // [
                //     'class' => 'yii\rest\UrlRule', 
                //     'controller' => 'v1/applyleave',
                //     'extraPatterns' => [
                //         'POST apply' => 'apply',
                //         'POST countday' => 'countday',
                //         'POST leavename' => 'leavename',
                //         'POST category' => 'category',
                //         'POST approvalstatus' => 'approvalstatus',
                //         'POST balance' => 'balance'
                //     ],
                //     'tokens' => [
                //         '{id}' => '<id:\\w+>'
                //     ],
                // ],

                // [
                //     'class' => 'yii\rest\UrlRule', 
                //     'controller' => 'v1/status',
                //     'extraPatterns' => [
                //         'POST status' => 'status',
                //         'POST statusdetail' => 'statusdetail',
                //         'POST statusadmin' => 'statusadmin',
                //         'POST statusdetailadmin' => 'statusdetailadmin',
                //         'POST dashboard' => 'dashboard',
                //         'POST dashboardadmin' => 'dashboardadmin'
                //     ],
                //     'tokens' => [
                //         '{id}' => '<id:\\w+>'
                //     ],
                // ],   

                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/master',
                    'extraPatterns' => [
                        'POST status' => 'departmentadd',
                        'POST statusdetail' => 'statusdetail',
                        'POST statusadmin' => 'statusadmin',
                        'POST statusdetailadmin' => 'statusdetailadmin',
                        'POST dashboard' => 'dashboard',
                        'POST dashboardadmin' => 'dashboardadmin'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                ],   
                
            ],        
        ]
    ],
    'params' => $params,
];



