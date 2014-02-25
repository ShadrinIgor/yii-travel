<?php


date_default_timezone_set('Europe/Kiev');
chdir(dirname(__FILE__).'/');
$root = dirname( __FILE__ ).'/';
$common = $root . 'framework';
$config = require($root.'protected/config/cron.php');
require_once($common.'/yii.php');

$app = Yii::createConsoleApplication($config)->run();
