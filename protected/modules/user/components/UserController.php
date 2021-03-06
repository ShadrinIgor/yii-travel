<?php

class UserController extends Controller
{
    var $addModel;
    var $tableName;
    var $name;
    var $dopSQL = "";

    public function init()
    {
        $userId = Yii::app()->user->getId();
        if( Yii::app()->user->isGuest || empty( $userId ) )
        {
            Yii::app()->session['redirect'] = $_SERVER["REQUEST_URI"];
            Yii::app()->user->logout();

            //if( Yii::app()->getLanguage() != "ru" )$lang = Yii::app()->getLanguage();

            $this->redirect( SiteHelper::createUrl( "/user" ) );
        }
    }

    public function actionNopublish()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Запись снята с публикации";
            $message = "";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $tableName = $this->addModel;
                $item = $tableName::fetch( $id );
                if( $item->id && $item->user_id->id == Yii::app()->user->getId() && $item->is_active != 0 )
                {
                    $message = "Запись снята с публикации";
                    $item->is_active = 0;
                    $item->save();
                }
            }

            $this->actionIndex( $message );
        }
    }

    public function actionPublish()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Запись опубликована";
            $message = "";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $tableName = $this->addModel;
                $item = $tableName::fetch( $id );
                if( $item->id && $item->user_id->id == Yii::app()->user->getId() && $item->is_active != 1 )
                {
                    $message = "Запись опубликована";
                    $item->is_active = 1;

                    if( !$item->save() )
                        print_r( $item->getErrors() );
                }
            }

            $this->actionIndex( $message );
        }
    }

    public function actionDelete()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Запись удалена";
            $message = "";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $tableName = $this->addModel;
                $item = $tableName::fetch( $id );
                if( $item->id && $item->user_id->id == Yii::app()->user->getId() )
                {
                    foreach( CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions(" item_id=:itemId AND catalog=:catalog ")
                                ->setParams( array( ":itemId"=>$item->id, ":catalog"=>$item->tableName() ) ) ) as $galItem )
                            $galItem->delete();

                    $message = "Запись удалена";
                    $item->delete();
                    SiteHelper::setLog( $item->tableName(), "delete", $item->id, Yii::app()->user->getId() );

                    if( is_array($item->getErrors()) && sizeof( $item->getErrors() )>0 )
                        print_r( $item->getErrors() );
                }
            }

            $this->actionIndex( $message );
        }
    }

    function uploadImages( $id )
    {
        $error = "";

        if( $id>0 )
        {
            ///////
            // Проверить колиство файлов - не более 6,8
            // Проверить нет ли общибок в $_FILES[][error]
            // Проверить размер фотографий не более 5,6 мв на каждую
            // проверитьтиф файлов пропускать только gif|jpg|png|jpeg

            $modelName = $this->addModel;
            $item = $modelName::fetch( $id );
            if( $item->id >0 )
            {
                // Для сохранения груп фотографий, будет задействованна фунция CCModel::save
                // а там уже будет сохранятся картинка, но там используется формат данных $_FILES как при одном файле а масиве
                // поэтому мы сохраним масив $_FILES затем его очистим и будет подставлять необходиммые для сохранения картинки значения
                if( !empty($_FILES["CatGallery"]) )
                {
                    $postImages = $_FILES["CatGallery"];

                    // Очищаем масив чтобы подставлять данные в нужном формате
                    unset( $_FILES["CatGallery"] );
                }

                // Проверем на наличие ошибок
                $haveError = false;

                if( empty($postImages) )
                {
                    $haveError = true;
                    $error = "Произошла ошибка скачивания";
                }

                if( !$error )
                {
                    for( $i=0;$i<sizeof( $postImages["name"]["images"] );$i++ )
                    {
                        if( $i>8 )
                        {
                            $error="Максимальное количество 8 файлов";
                            break;
                        }

                        $error = ImageHelper::checkError( $postImages["type"]["images"][$i], $postImages["size"]["images"][$i], $postImages["error"]["images"][$i], array("jpg","jpeg"), 5242880 );
                        if( empty( $error ) ) // 5mb
                        {
                            $_FILES["CatGallery"]=array(
                                "name"     => array( "image" => $postImages["name"]["images"][$i] ),
                                "type"     => array( "image" => $postImages["type"]["images"][$i] ),
                                "tmp_name" => array( "image" => $postImages["tmp_name"]["images"][$i] ),
                                "error"    => array( "image" => $postImages["error"]["images"][$i] ),
                                "size"     => array( "image" => $postImages["size"]["images"][$i] ),
                            );

                            $addGallery = new CatGallery();
                            $addGallery->image = $postImages["name"]["images"][$i];
                            $addGallery->catalog = $this->tableName;
                            $addGallery->item_id = $id;
                            $addGallery->save();

                            if( $addGallery->getErrors() && sizeof( $addGallery->getErrors() )>0 )
                                print_r( $addGallery->getErrors() );
                        }
                    }

                    if( !$error )$this->redirect( SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description/", array( "id"=>$id  )) );
                            else $this->redirect( SiteHelper::createUrl("/user/".Yii::app()->controller->getId()."/description/", array( "id"=>$id, "error"=>"gallError" )) );
                }
            }
            else throw new Exception( "Ошибка групповой закачи картиноку ( Указанному ID нет соответствующей записи )" );
        }
        else throw new Exception( "Ошибка групповой закачи картиноку ( Не указан ID )" );
    }

    /*
     * Сохранение описание для фотографи
     */
    public function gallerySaveTitle()
    {
        if( !empty( $_POST["saveTitle"] ) )
        {
            $id = (int)Yii::app()->request->getParam("id", 0);
            if( $id >0  )
            {
                $modelClass = SiteHelper::getCamelCase( $this->tableName );
                $item = $modelClass::fetch( $id );
                if( $item && $item->id>0 )
                {
                    if( !empty( $_POST["ITitle"] ) )$values = $_POST["ITitle"];
                                               else $values = arrray();

                    $listGallery = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams( array( ":catalog"=>$this->tableName, ":item_id"=>$item->id ) )->setLimit(50)->setCache(0) );
                    foreach( $listGallery as $itemGallery )
                    {
                        $title = !empty( $values[$itemGallery->id] ) ? $values[$itemGallery->id] : "";
                        $itemGallery->name =SiteHelper::checkedVaribal( $title );
                        $itemGallery->save();
                        if( is_array( $itemGallery->getErrors ) && sizeof( $itemGallery->getErrors() ) )print_r( $itemGallery->getErrors() );
                    }
                }
            }
        }
    }

    public function actionIndex( $inputMessage = "" )
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Мои ".$this->name;
            $message = "";

            if( empty( $message ) && !empty( $inputMessage ) )$message = $inputMessage;

            $modelClass = SiteHelper::getCamelCase( $this->tableName );
            if( !empty( $modelClass ) )
            {
                $items = $modelClass::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("user_id=:user_id".$this->dopSQL)->setParams( array( ":user_id"=>Yii::app()->user->id ) )->setOrderBy("id DESC")->setLimit(-1)->setCache(0) );
                $this->render( "index", array( "items"=>$items, "message"=>$message ) );
            }
        }
    }

    public function actionDescription( $gallError = "" )
    {
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
                    if( property_exists( $item, "edit_date" ) )$item->edit_date = time();

                    $item->user_id = Yii::app()->user->getId();
                    if( $item->save() )
                    {
                        if( $isAdd )$action = "create";
                               else $action = "edit";

                        SiteHelper::setLog( $item->tableName(), $action, $item->id, Yii::app()->user->getId() );

                        switch( Yii::app()->controller->getId() )
                        {
                            case "firms" : LogHelper::saveCatLogEdit(1,0);break;
                            case "tours" : LogHelper::saveCatLogEdit(0,1);break;
                        }

                        $arrayParam = array("id"=>$item->id, "status"=>"saved");
                        if( $firm->id > 0 )$arrayParam["fid"] = $firm->id;

                        switch( $item->tableName() )
                        {
                            case "catalog_firms" : $item->onAddFirm( new CModelEvent( $item ), array( ) );break;
                            case "catalog_tours" : $item->onAddTour( new CModelEvent( $item ), array( ) );break;
                            case "catalog_firms_items" : $item->onAddFirmsItems( new CModelEvent( $item ), array( ) );break;
                            case "catalog_firms_service" : $item->onAddFirmsService( new CModelEvent( $item ), array( ) );break;
                            case "catalog_firms_banner" : $item->onAddFirmsBanners( new CModelEvent( $item ), array( ) );break;
                        }

                        // Добавляем в очередь на нотификацию
                        // В течении 24 часов после добавления или сохранения пользователю приходят уведомления
                        // О том что заполнил не полностью, не опубликовал, не добавил картинок и т.д.
                        AutoNotifier::addInNotificationsQueue( $item->tableName(), $item->id );

                        $this->redirect( SiteHelper::createUrl( "/user/".Yii::app()->controller->getId()."/description/", $arrayParam ) );
                        die;
                    }
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

                if( !empty( $message ) )$item->formMessage = $message;
                $this->render( "description", array( "item"=>$item, "firm"=>$firm, "listGallery"=>$listGallery, "message"=>$message, "addImage"=>$addImage, "comMessage"=>$comMessage, "gallMessage"=>$gallMessage, "listComments"=>$listComments ) );
        }
        }
    }
}