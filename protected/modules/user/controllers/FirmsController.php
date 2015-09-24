<?php

class FirmsController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogFirmsAdd";
        $this->tableName = "catalog_firms";
        $this->name = Yii::t("user", "фирмы");
    }

    public function actionDelete()
    {
        Yii::app()->page->title = Yii::t("user", "Запись удалена");
        $message = "";

        $id = (int)Yii::app()->request->getParam("id", 0);
        $catalog = Yii::app()->request->getParam("catalog");

        if( $id>0 && !empty( $catalog ) )
        {
            $item = $catalog::fetch( $id );
            if( $item->user_id && $item->user_id->id >0 )$id = $item->user_id->id;
                                                    else $id = $item->firm_id->user_id->id;

            if( $item->id > 0 && $id == Yii::app()->user->getId() )
            {
                foreach( CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions(" item_id=:itemId AND catalog=:catalog ")
                    ->setParams( array( ":itemId"=>$item->id, ":catalog"=>$item->tableName() ) ) ) as $galItem )
                    $galItem->delete();

                $item->delete();
                SiteHelper::setLog( $item->tableName(), "delete", $item->id, Yii::app()->user->getId() );
                echo 1;
                return;
            }
        }

        return;
    }
 /*
    public function actionTourDelete()
    {
        Yii::app()->page->title = "Запись удалена";
        $message = "";

        $id = (int)Yii::app()->request->getParam("id", 0);
        $tid = (int)Yii::app()->request->getParam("tid", 0);



        if( !empty( $id ) && !empty( $tid ) )
        {

            $tableName = $this->addModel;
            $item = $tableName::fetch( $id );
            if( $item->id && $item->user_id->id == Yii::app()->user->getId() )
            {
                $tourModel = CatalogTours::fetch( $tid );
                if( $tourModel->id >0 && $tourModel->firm_id->id == $item->id )
                {
                    foreach( CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions(" item_id=:itemId AND catalog=:catalog ")
                        ->setParams( array( ":itemId"=>$tourModel->id, ":catalog"=>"catalog_tours" ) ) ) as $galItem )
                        $galItem->delete();

                    $tourModel->delete();

                    if( is_array($tourModel->getErrors()) && sizeof( $tourModel->getErrors() )>0 )
                        print_r( $tourModel->getErrors() );
                }
            }
        }

        $this->actionDescription( );
    }*/

    public function actionCommentRead()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        if( $id >0 )
        {
            $commentModel = CatalogFirmsCommentsAdd::fetch( $id );
            if( $commentModel->id > 0 && $commentModel->user_id->id == Yii::app()->user->getId() )
            {
                $commentModel->is_new = 0;
                $commentModel->save();
                echo true;
                return;
            }
        }

        echo false;
        return;
    }

    public function actionSetPublish()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        $catalog = Yii::app()->request->getParam("catalog");

        if( $id >0 && !empty( $catalog ) )
        {

            $newCatalog = new $catalog();
            $modelClass = SiteHelper::getCamelCase( $newCatalog->tableName() );
            $model = $modelClass::fetch( $id );
            $listImages = CatGallery::findByAttributes( array("catalog"=>$newCatalog->tableName(), "item_id"=>$id) );
            $imagesMin = SiteHelper::getConfig( "publish_min_images" );
            $sizeofImages = sizeof( $listImages );
            if( $model->image )$sizeofImages ++;

            // Для CatalogFirmsBannersAdd не должно влиять ограичение перед публиацией по количесву картинок
            if( $sizeofImages>=$imagesMin || $catalog == "CatalogFirmsBannersAdd"  || $catalog == "CatalogFirmsBanners" )
            {
                $error = false;
                $commentModel = $catalog::fetch( $id );
                if( ( $catalog == "CatalogFirmsBannersAdd" || $catalog == "CatalogFirmsBanners" ) && !$commentModel->file )$error = true;
                if( $commentModel->user_id->id != Yii::app()->user->getId() && $commentModel->firm_id->user_id->id != Yii::app()->user->getId() )$error = true;

                if( !$error )
                {
                    if( $commentModel->user_id && $commentModel->user_id->id >0 )$id = $commentModel->user_id->id;
                                                                            else $id = $commentModel->firm_id->user_id->id;

                    if( $commentModel->id > 0 && $id == Yii::app()->user->getId() )
                    {
                        if( $commentModel->active == 0 ){$commentModel->active = 1;$action="publish";}
                                                   else {$commentModel->active = 0;$action="nopublish";}

                        SiteHelper::setLog( $newCatalog->tableName(), $action, $commentModel->user_id->id, Yii::app()->user->getId() );
                        if( $commentModel->save() )echo 1;
                        else print_r( $commentModel->getErrors() );
                        return;
                    }
                }
            }
                else
            {
                echo 3;
                return;
            }
        }

        echo 0;
        return;
    }
}
