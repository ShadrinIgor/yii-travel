<?php

class ToursController extends UserController
{
    var $firmId;

    public function init()
    {
        $items = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id in ( SELECT id FROM catalog_firms WHERE user_id='".Yii::app()->user->getId()."' )") );
        $this->render("index", [ "items"=>$items ]);
    }

    public function actionDescription( $gallError = "" )
    {
        $this->firmId = (int) Yii::app()->request->getParam("fid", 0);
        $id = (int) Yii::app()->request->getParam("id", 0);

        // Если не указан ID фирмы, то берем ID из описания тура
        if( $id>0 && $this->firmId == 0 )
        {
            $tourModel = CatalogTours::fetch( $id );
            if( $tourModel->id>0 && $tourModel->firm_id && $tourModel->firm_id->id >0 )
                $this->firmId  = $tourModel->firm_id->id;
        }

        if( $this->firmId == 0  )
        {
            die(  "id==0" );
            $this->redirect( SiteHelper::createUrl("/user/firms") );
        }

        $firmModel = CatalogFirms::fetch( $this->firmId );
        if( $firmModel->id == 0 )
        {
            die(  "id==not correct" );
            $this->redirect( SiteHelper::createUrl("/user/firms") );
        }

        parent::init();
        $this->addModel = "CatalogToursAdd";
        $this->tableName = "catalog_tours";
        $this->name = Yii::t("user", "туры" );

        $_POST["CatalogToursAdd"]["firm_id"] = $this->firmId;
        $_POST["CatalogToursAdd"]["user_id"] = Yii::app()->user->getId();
        parent::actionDescription();
    }
}
