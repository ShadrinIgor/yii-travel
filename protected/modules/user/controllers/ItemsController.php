<?php

class ItemsController extends Controller
{
    public function actionIndex( $inputMessage = "" )
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Мои объявления";
            $message = "";

            $hide = (int)Yii::app()->request->getParam("hide", 0);
            if( $hide>0 )
            {
                $hideItem = Notifications::fetch( $hide );
                if( $hideItem->id >0 && $hideItem->user_id->id == Yii::app()->user->id )
                {
                    $hideItem->is_new = 0;
                    $hideItem->save();
                }
            }

            $action = (int)Yii::app()->request->getParam( "delete", 0 );
            if( $action>0 )
            {
                $itemModel = CatalogItems::fetch( $action );
                if( $itemModel->id >0 && $itemModel->user_id->id == Yii::app()->user->id )
                {
                    $message = "Объявление успешно удаленно";
                    $itemModel->delete();
                }
            }

            $hot = Yii::app()->request->getParam("hot", "");
            if( $hot == "save" )$message = "Услуга успешно применена";
            if( empty( $message ) && !empty( $inputMessage ) )$message = $inputMessage;

            $items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("user_id=:user_id")->setParams( array( ":user_id"=>Yii::app()->user->id ) )->setOrderBy("id DESC")->setLimit(-1)->setCache(0) );
            $this->render( "index", array( "items"=>$items, "message"=>$message ) );
        }
    }

    public function actionHot()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Добавление объявления в горячие";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $item = CatalogItems::fetch( $id );
                if( $item->id && $item->status_id->id != 2 )
                {
                    $error = "";
                    $serviceModel = CatalogServices::fetchByKeyWord( "add_in_hot" );

                    if( !empty( $_POST["pay_order"] ) )
                    {
                        if( $item->is_hot == 0 )
                        {
                            if(
                                UserHelper::getAmount()>=$serviceModel->price &&
                                $item->user_id->id == Yii::app()->user->id
                            )
                            {
                                $item->is_hot = 1;
                                if( $item->save() )
                                {
                                    // Создаем заказ на пополнения счета
                                    $newOrder = new OrderRequest();
                                    $newOrder->user_id = Yii::app()->user->id;
                                    $newOrder->date = time();
                                    $newOrder->catalog = "catalog_items";
                                    $newOrder->item_id = $id;
                                    $newOrder->status_id = 3;
                                    $newOrder->amount = $serviceModel->price;
                                    $newOrder->finish_date = time();
                                    $newOrder->type_id = 1;
                                    $newOrder->save();

                                    // Списываем средства со счета пользоватля
                                    $userModel = CatalogUsers::fetch( Yii::app()->user->id );
                                    $userModel->amount = $userModel->amount - $serviceModel->price;
                                    $userModel->save();

                                    $this->redirect( SiteHelper::createUrl( "/user/items", array( "hot"=>"save" ) ) );
                                }
                                else $error = "Произошла ошибка оплаты, попробуйте еще раз.";
                            }
                            else $error = "Произошла ошибка оплаты, попробуйте еще раз.";
                        }
                        else $error = "Выбранная услуга была оплачена ранее.";
                    }

                    $this->render( "hot", array( "item"=>$item, "serviceModel"=>$serviceModel, "error"=>$error ) );
                }
            }
        }
    }

    public function actionModeration()
    {
        if( !Yii::app()->user->isGuest )
        {
            $message = "";
            Yii::app()->page->title = "Объявление передено на модереацию";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $item = CatalogItems::fetch( $id );
                if( $item->id )
                {
                    $listGallery = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setLimit(-1)->setCache(0) );
                    if( sizeof( $listGallery )>=SiteHelper::getConfig( "min_count_photo" ) )
                    {
                        $error = "";
                        $item->date = time();
                        $item->status_id = 2;
                        $message = "Объявление передено на модереацию";
                        if( !$item->save() )
                            print_r( $item->getErrors() );
                    }
                        else $message = "Для публикации объявления необходимо залить минимум ".SiteHelper::getConfig( "min_count_photo" )." фотографий";
                }
            }

            $this->actionIndex( $message );
        }
    }

    public function actionNopublish()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Объявления снято с публикации";
            $message = "";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $item = CatalogItems::fetch( $id );
                if( $item->id && $item->status_id->id != 2 )
                {
                    $message = "Объявления снято с публикации";
                    $item->status_id = 3;
                    $item->save();
                }
            }

            $this->actionIndex( $message );
        }
    }

    public function actionDescription()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Описание объявления";

            $id = (int)Yii::app()->request->getParam("id", 0);
            $fid = (int)Yii::app()->request->getParam("fid", 0);
            if( !empty( $id ) )
            {
                $item = CatalogItemsAdd::fetchParam( $id );
                if( $item->id )
                {
                    if( $item->firmid->id>0 )$firmModel = $item->firm_id;
                            elseif( $fid>0 )$firmModel = CatalogFirms::fetch( $fid );
                    $message = "";
                    if( !empty( $_POST["update_tree"] ) )
                    {
                        $item->setAttributesFromArray( $_POST["CatalogItemsAdd"] );
                        if( $item->status_id == 1 )$item->status_id = 2;
                        if( $item->saveParam() )$message = "Описание успешно обновленно";
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
                        $comModel = CatalogItemsComments::fetch( $comm_id );
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
                        $addImage->setAttributesFromArray( $_POST["CatGalleryAdd"] );
                        $addImage->catalog = $item->tableName();
                        $addImage->item_id = $item->id;
                        $addImage->image = $_FILES["CatGalleryAdd"]["name"]["image"];
                        if( $addImage->save() )
                        {
                            $addImage = new CatGalleryAdd();
                            $addImage->formMessage = "Галлерея успешно обновленна";
                        }
                    }

                    $listComments = CatalogItemsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("item_id=:item_id")->setParams( array( ":item_id"=>$item->id ) )->setOrderBy("is_new DESC, date DESC")->setLimit(50)->setCache(0) );
                    $listGallery = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$item->tableName(), ":item_id"=>$item->id ) )->setLimit(50)->setCache(0) );

                    $this->render( "description", array( "firm"=>$firmModel, "item"=>$item, "listGallery"=>$listGallery, "message"=>$message, "addImage"=>$addImage, "comMessage"=>$comMessage, "gallMessage"=>$gallMessage, "listComments"=>$listComments ) );
                }
                    else $this->redirect("/");
            }
                else $this->redirect("/");
        }
    }

}
