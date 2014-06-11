<?php

class WorkController extends UserController
{
    var $firmId;

    public function init()
    {
        parent::init();
        $this->addModel = "CatalogWorkAdd";
        $this->tableName = "catalog_work";
        $this->name = Yii::t("user", "Мои вакансии");
        $this->dopSQL = " AND type_id=2";

        $this->firmId = (int) Yii::app()->request->getParam("fid", 0);
        $id = (int) Yii::app()->request->getParam("id", 0);
        $return = false;
    }

    public function actionDescription( $gallError = "" )
    {
        $_POST["CatalogWorkAdd"]["user_id"] = Yii::app()->user->getId();
        $_POST["CatalogWorkAdd"]["type_id"] = 2;

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

            if( !$item->id || $item->user_id->id == Yii::app()->user->getId()  )
            {
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

                        $this->redirect( SiteHelper::createUrl( "/user/".Yii::app()->controller->getId()."/description/", array("id"=>$item->id, "status"=>"saved") ) );
                        die;
                        //if( !$isAdd )$message = "Описание успешно обновленно";
                        //        else $message = "Запись успешно добавлена";
                    }
                    //                    else $message = "Произошла ошибка обновления описания";
                }

                $action = Yii::app()->request->getParam( "action" );
                $gall_id = (int) Yii::app()->request->getParam( "gall_id", 0 );
                $comMessage = "";
                $gallMessage = "";
                if( !empty($gallError) )$message = $gallError;
                // Удаление фотографии
                if( !empty($action) && $gall_id>0 )
                {
                    $comModel = CatGallery::fetch( $gall_id );
                    if( $comModel->id >0 && $comModel->item_id == $item->id )
                    {
                        if( $action == "delGallery" )
                        {
                            $comModel->delete();
                            $gallMessage = Yii::t("user", "Картинка удалена");
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
                            $comMessage = Yii::t("user", "Комментарий удален");
                        }

                        if( $action == "validComment" )
                        {
                            $comModel->is_valid = 1;
                            $comModel->save();
                            $comMessage = Yii::t("user", "Комментарий успешно опубликован");
                        }
                    }
                }

                $addImage = new CatGalleryAdd();
                if( $error == "gallError" )$addImage->addError( "error upload", Yii::t("user", "Произошла ошибка добавления фото, попробуте заново или обратитеcь к тех. потдержке")." ( Email : ".Yii::app()->params["supportEmail"]." ) " );
                if( !empty( $_POST["sendGallery"] ) )
                {
                    if( $id>0 )$this->uploadImages( (int) $id, get_class( $item ) );
                }

                // Сохранение подписи для фотографий
                if( !empty( $_POST["saveTitle"] ) )$this->gallerySaveTitle();

                $listComments = CatComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setLimit(50)->setCache(0) );
                $listGallery = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setLimit(50)->setCache(0) );


                $this->render( "description", array( "item"=>$item, "firm"=>null, "listGallery"=>$listGallery, "message"=>$message, "addImage"=>$addImage, "comMessage"=>$comMessage, "gallMessage"=>$gallMessage, "listComments"=>$listComments ) );
            }
        }
    }
}
