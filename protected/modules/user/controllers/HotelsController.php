<?php

class HotelsController extends UserController
{
    public function init()
    {
        $this->addModel = "CatalogHotelsAdd";
        $this->tableName = "catalog_hotels";
    }

    public function actionIndex( $inputMessage = "" )
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Мои отели";
            $message = "";

            if( empty( $message ) && !empty( $inputMessage ) )$message = $inputMessage;

            $items = CatalogHotels::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("user_id=:user_id")->setParams( array( ":user_id"=>Yii::app()->user->id ) )->setOrderBy("id DESC")->setLimit(-1)->setCache(0) );
            $this->render( "index", array( "items"=>$items, "message"=>$message ) );
        }
    }

    public function actionDescription()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Описание";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )$item = CatalogHotelsAdd::fetch( $id );
                          else $item = new CatalogHotelsAdd();

            $message = "";
            if( !empty( $_POST["update"] ) )
            {
                if( !$item->id )$isAdd = true;
                           else $isAdd = false;

                $item->setAttributesFromArray( $_POST["CatalogHotelsAdd"] );
                $item->is_resume = 0;
                if( !$item->date )$item->date = time();
                $item->user_id = Yii::app()->user->getId();
                if( $item->save() )
                {
                    if( !$isAdd )$message = "Описание успешно обновленно";
                            else $message = "Отель успешно добавлен";
                }
                              else $message = "Произошла ошибка обновления описания";
            }

            $action = Yii::app()->request->getParam( "action" );
            $gall_id = (int) Yii::app()->request->getParam( "gall_id", 0 );
            $comMessage = "";
            $gallMessage = "";
            if( !empty($action) && $gall_id>0 )
            {
                $comModel = CatGallery::fetch( $gall_id );
                if( $comModel->id >0 && $comModel->item_id == $item->id )
                {
                    if( $action == "delGallery" )
                    {
                        $comModel->delete();
                        $gallMessage = "Картинка удалена";
                    }
                }
            }

            $comm_id = (int) Yii::app()->request->getParam( "comm_id", 0 );
            if( !empty($action) && $comm_id>0 )
            {
                $comModel = CatComments::fetch( $comm_id );
                if( $comModel->id >0 && $comModel->item_id->id == $item->id )
                {
                    if( $action == "delComment" )
                    {
                        $comModel->delete();
                        $comMessage = "Коментарий удален";
                    }

                    if( $action == "validComment" )
                    {
                        $comModel->is_valid = 1;
                        $comModel->save();
                        $comMessage = "Коментарий успешно опубликован";
                    }
                }
            }

            $addImage = new CatGalleryAdd();
            if( !empty( $_POST["sendGallery"] ) )
            {
                if( $id>0 )$this->uploadImages( (int) $id, get_class( $item ) );
            }

            $listComments = CatComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setLimit(50)->setCache(0) );
            $listGallery = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setLimit(50)->setCache(0) );

            $this->render( "description", array( "item"=>$item, "listGallery"=>$listGallery, "message"=>$message, "addImage"=>$addImage, "comMessage"=>$comMessage, "gallMessage"=>$gallMessage, "listComments"=>$listComments ) );
        }
    }

}
