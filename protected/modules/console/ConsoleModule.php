<?php

class ConsoleModule extends CWebModule
{
    public function init()
    {
        Yii::import("modules.console.components.*");
        Yii::import("modules.console.models.*");
        define( "CONSOLE_PANEL", TRUE );

        error_reporting(1);
        ini_set('display_errors', 1);
        defined('YII_DEBUG') or define('YII_DEBUG',true);
    }
}