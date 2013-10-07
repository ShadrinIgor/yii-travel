<?php

class FindModule extends CWebModule
{
    public function init()
    {
        Yii::import("modules.find.components.*");
        Yii::import("modules.find.models.*");
    }
}