<?php

class WindingProxiCommand extends CConsoleCommand
{
    public function run($args)
    {
        Yii::app()->winding->updateListProxi();
    }
}