<?php
use \yii\web\Request;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

// Replace url
$baseUrlBack = str_replace('/backend/web', '/admin', (new Request)->getBaseUrl());
$baseUrlBack = str_replace('/frontend/web', '/admin', $baseUrlBack);
$baseUrlFront = str_replace('/backend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'i18n'            => [
            'translations' => [
                'writesdown' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'basePath'       => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap'        => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'request'         => [
            'baseUrl' => $baseUrlBack,
        ],
        'urlManager'      => [
            'baseUrl'         => $baseUrlBack,
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => []
        ],
        'urlManagerFront' => [
            'class'           => 'yii\web\urlManager',
            'baseUrl'         => $baseUrlFront,
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'p/<post_type:[\w-@]+>'                                          => 'post/index',
                'p/<post_type:[\w-@]+>/<post_slug:[\w-@]+>'                      => 'post/view',
                'p/<post_type:[\w-@]+>/<post_slug:[\w-@]+>/<media_slug:[\w-@]+>' => 'media/view',
                'c/<taxonomy_slug:[\w-@]+>/<term_slug:[\w-@]+>'                  => 'term/view',
                'a/author/<username:[\w-@]+>'                                    => 'user/view',
                'm/media/<media_slug:[\w-@]+>'                                   => 'media/view',
            ]
        ],
        'urlManagerBack'  => [
            'class'           => 'yii\web\urlManager',
            'baseUrl'         => $baseUrlBack,
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => []
        ],
        'authManager'     => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,
];