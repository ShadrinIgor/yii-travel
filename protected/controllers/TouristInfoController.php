<?php

class TouristInfoController extends InfoController
{
    var $slug;
	public function init()
    {
        parent::init();
        $this->classModel = "CatalogInfo";
        $this->classCategory = "CatalogInfoCategory";
    }
}