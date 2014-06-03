<?php

class HotelsController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogHotelsAdd";
        $this->tableName = "catalog_hotels";
        $this->name = Yii::t("user", "отели");
    }
}
