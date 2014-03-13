<?php

class SubscribeModule extends CWebModule
{
    public function init()
    {
        Yii::import("modules.subscribe.components.*");
        Yii::import("modules.subscribe.models.*");
    }
}