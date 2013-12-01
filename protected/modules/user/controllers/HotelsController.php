<?php

class HotelsController extends UserController
{
    public function init()
    {
        $this->addModel = "CatalogHotelsAdd";
        $this->tableName = "catalog_hotels";
        $this->name = "отели";
    }
}
