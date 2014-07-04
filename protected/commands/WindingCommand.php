<?php

class WindingCommand extends CConsoleCommand
{
    public function run($args)
    {
        Yii::app()->winding->userVisit();
    }
}