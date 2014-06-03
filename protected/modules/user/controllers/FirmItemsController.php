<?php

class FirmItemsController extends UserController
{
    var $firmId;

    public function init()
    {
        parent::init();
        $this->addModel = "CatalogFirmsItemsAdd";
        $this->tableName = "catalog_firms_items";
        $this->name = Yii::t("user", "Акции/скидки компании" );

        $this->firmId = (int) Yii::app()->request->getParam("fid", 0);
        $id = (int) Yii::app()->request->getParam("id", 0);
        $return = false;

        // Если не указан ID фирмы, то берем ID из описания тура
        if( $id>0 && $this->firmId == 0 )
        {
            $class = $this->addModel;
            $tourModel = $class::fetch( $id );
            if( $tourModel->id>0 && $tourModel->firm_id && $tourModel->firm_id->id >0 )$this->firmId  = $tourModel->firm_id->id;
                else $return = true;
        }

        if( $return == true  )$this->redirect( SiteHelper::createUrl("/user/firms") );
    }

    public function actionDescription( $gallError = "" )
    {
        $_POST["CatalogFirmsItemsAdd"]["firm_id"] = $this->firmId;
        $_POST["CatalogFirmsItemsAdd"]["user_id"] = Yii::app()->user->getId();
        parent::actionDescription();
    }
}
