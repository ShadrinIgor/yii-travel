<?php

class ConsoleModule extends CWebModule
{
    public function init()
    {
        Yii::import("modules.console.components.*");
        Yii::import("modules.console.models.*");
        define( "CONSOLE_PANEL", TRUE );
    }
}