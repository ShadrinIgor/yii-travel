<?php

class ToursController extends UserController
{
    var $firmId;

    public function init()
    {
        parent::init();
        $this->addModel = "CatalogToursAdd";
        $this->tableName = "catalog_tours";
        $this->name = Yii::t("user", "туры");
/*        $items = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("firm_id in ( SELECT id FROM catalog_firms WHERE user_id='".Yii::app()->user->getId()."' )") );
        $this->render("index", [ "items"=>$items ]);*/
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

        $firmModel = "";
        if( !$firmModel || $firmModel->id == 0 )
        {
            $firmModelArray = CatalogFirms::fetchAll( "user_id=".Yii::app()->user->getId() );
            if ( sizeof( $firmModelArray ) >0 )$firmModel = $firmModelArray[0];
        }

        # TODO надо сделать всплывающее окошко с уведомление, для добавления тура необходимо зарегить компанию
        /*
        if( $this->firmId == 0  )
        {
            $this->redirect( SiteHelper::createUrl("/user/firms") );
        }
        */


        if( $firmModel->id >0 )
        {
            parent::init();
            $this->addModel = "CatalogToursAdd";
            $this->tableName = "catalog_tours";
            $this->name = Yii::t("user", "туры");

            $_POST["CatalogToursAdd"]["firm_id"] = $firmModel->id;
            $_POST["CatalogToursAdd"]["user_id"] = Yii::app()->user->getId();
            parent::actionDescription();
        }
    }
}
