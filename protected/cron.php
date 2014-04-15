<?php

date_default_timezone_set('Europe/Moscow');
chdir(dirname(__FILE__).'/');
$root = dirname( dirname(__FILE__) ).'/';
$common = $root . '/framework';
require_once($common.'/yii.php');
$config = require('config/cron.php');
$app = Yii::createConsoleApplication($config)->run();
