<?php

require(__DIR__ . '/bootstrap.php');

$config = [
  'id' => 'basic',
  'basePath' => $APP_ROOT,
  'bootstrap' => ['log'],
  'modules' => [
    'v1' => [
      'basePath' => '@api/modules/v1',
      'class' => 'api\modules\v1\Module'
    ]
  ],
  'components' => [
    'request' => [
      'cookieValidationKey' => 'kwFp95nFdfK7VmYNBmvnSACc3WGmbjPV',
    ],
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
      'class' => 'yii\swiftmailer\Mailer',
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
    'db' => $COMMON_DB_CONFIG,
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        [
          'class' => 'yii\rest\UrlRule',
          'controller' => 'v1/post',
          'pluralize' => false,
        ],
      ],
    ],
  ],
  'params' => $params,
];

return $config;
