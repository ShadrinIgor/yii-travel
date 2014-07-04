<?php

class WindingSessionCommand extends CConsoleCommand
{
    public function run($args)
    {
        Yii::app()->winding->checkSession();
    }
}