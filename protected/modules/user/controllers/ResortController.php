<?php

class ResortController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogKurortsAdd";
        $this->tableName = "catalog_kurorts";
        $this->name = Yii::t("user", "зоны отдыха/дачи" );
    }
}
