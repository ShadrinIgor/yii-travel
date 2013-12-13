<?php

class FirmsController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogFirmsAdd";
        $this->tableName = "catalog_firms";
        $this->name = "фирмы";
    }
}
