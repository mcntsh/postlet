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
      'parsers' => [
        'application/json' => 'yii\web\JsonParser',
      ]
    ],
    'response' => [
      'formatters' => [
        \yii\web\Response::FORMAT_JSON => [
          'class' => 'yii\web\JsonResponseFormatter',
        ],
      ],
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'user' => [
      'identityClass' => 'common\models\Account',
      'enableSession' => false,
      'loginUrl' => null,
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
          'controller' => [
            'v1/post', 'v1/account'
          ],
          'pluralize' => false,
        ],
      ],
    ],
  ],
  'params' => require($PROJECT_ROOT . '/common/config/params.php'),
];

return $config;
