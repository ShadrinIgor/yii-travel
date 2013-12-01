<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
date_default_timezone_set('Europe/Moscow');

require_once($yii);

Yii::setPathOfAlias('viewsLayouts', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."layouts");
Yii::setPathOfAlias('modules', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."modules");
Yii::setPathOfAlias('configPath', dirname(__DIR__)."/protected".DIRECTORY_SEPARATOR."config");

Yii::createWebApplication($config)->run();

