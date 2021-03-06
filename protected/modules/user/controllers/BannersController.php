<?php

class BannersController extends UserController
{
    var $firmId;

    public function init()
    {
        parent::init();
        $this->addModel = "ExBannerAdd";
        $this->tableName = "ex_banner";
        $this->name = Yii::t("user", "БЕСПЛАТНЫЕ баннеры");
    }

    public function actionDescription( $gallError = "" )
    {
        $_POST["CatalogFirmsBannersAdd"]["firm_id"] = $this->firmId;
        $_POST["CatalogFirmsBannersAdd"]["user_id"] = Yii::app()->user->getId();

        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title =  Yii::t("page", "Описание");

            $id = (int)Yii::app()->request->getParam("id", 0);
            $status = Yii::app()->request->getParam("status", "");
            $error = Yii::app()->request->getParam("error", "");
            $addClass = $this->addModel;
            if( !empty( $id ) )$item = $addClass::fetch( $id );
                else
            {
                $item = new $addClass();
                SiteHelper::setLog( $item->tableName(), "open_add_form", $item->id, Yii::app()->user->getId() );
            }

            $count = CatalogBannerRequest::count();
            $maxCount = SiteHelper::getConfig( "banner_max_count" );
            $checkedRequest = CatalogBannerRequest::findByAttributes( array( "banner_id"=>$item->id ) );

            if( !$item->id || ( ( $item->user_id && $item->user_id->id == Yii::app()->user->getId() ) || ( $item->firm_id && $item->firm_id->user_id->id == Yii::app()->user->getId() ) ) )
            {
                if( property_exists( $item, "firm_id" ) && $item->firm_id )$firm = $item->firm_id;
                if( !property_exists( $item, "firm_id" ) && $item->id )$firm = $item;

                if( empty( $firm ) || $firm->id == 0 )
                {
                    $fid = (int)Yii::app()->request->getParam("fid", 0);
                    $firm = CatalogFirms::fetch( $fid );
                }

                $message = ( !empty( $status ) && $status == 'saved' ) ? Yii::t("user", "Сохранено") : "";

                // Описание объявления
                if( !empty( $_POST["update"] ) )
                {
                    if( !$item->id )$isAdd = true;
                               else $isAdd = false;

                    $item->setAttributesFromArray( $_POST[ $addClass ] );
                    //$item->is_resume = 0;
                    if( !$item->date )$item->date = time();
                    $item->user_id = Yii::app()->user->getId();
                    if( $item->save() )
                    {
                        if( $isAdd )$action = "create";
                               else $action = "edit";

                        SiteHelper::setLog( $item->tableName(), $action, $item->id, Yii::app()->user->getId() );

                        if( !empty( $_POST["banner_request"] ) )
                        {
                            if( $count<$maxCount )
                            {
                                if( sizeof( $checkedRequest ) == 0 )
                                {
                                    $newRequest = new CatalogBannerRequest();
                                    $newRequest->banner_id = $item->id;
                                    $newRequest->date = time();
                                    $newRequest->active = 0;
                                    $newRequest->save();
                                    $newRequest->onBannerRequest( new CModelEvent($newRequest), array( "id"=>$newRequest->id, "date"=>date( "d.m.Y" ) ) );
                                }
                            }
                        }
                        $this->redirect( SiteHelper::createUrl( "/user/".Yii::app()->controller->getId()."/description/", array("id"=>$item->id, "fid"=>$firm->id, "status"=>"saved" ) ) );
                        die;
                    }
                }

                $this->render( "description", array( "checkedRequest"=>sizeof( $checkedRequest ), "count"=>$count, "maxCount"=>$maxCount, "item"=>$item, "firm"=>$firm, "listGallery"=>array(), "message"=>$message, "addImage"=>null, "comMessage"=>"", "gallMessage"=>"", "listComments"=>array() ) );
            }
        }
    }
}
