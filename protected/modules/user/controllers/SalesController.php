<?php

class SalesController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogFirmsItemsAdd2";
        $this->tableName = "catalog_firms_items";
        $this->name = Yii::t("user", "скидки и акции");
    }
}
