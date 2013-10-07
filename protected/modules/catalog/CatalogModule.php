<?php

class CatalogModule extends CWebModule
{
    public function init()
    {
        Yii::import("modules.catalog.components.*");
        Yii::import("modules.catalog.models.*");
    }
}