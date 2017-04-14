<?php

$APP_ROOT = dirname(__DIR__);
$PROJECT_ROOT = dirname($APP_ROOT);
$COMMON_DIR = $PROJECT_ROOT . '/common';

$COMMON_DB_CONFIG = require($COMMON_DIR . '/config/db.php');
$COMMON_PARAMS_CONFIG = require($COMMON_DIR . '/config/params.php');

Yii::setAlias('@api', $PROJECT_ROOT . '/api');
