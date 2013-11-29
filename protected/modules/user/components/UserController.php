<?php

class UserController extends Controller
{
    var $addModel;
    var $tableName;
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
                    $message = "Запись удалена";
                    $item->delete();

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
                        if( $error = ImageHelper::checkError( $postImages["type"]["images"][$i], $postImages["size"]["images"][$i], $postImages["error"]["images"][$i], array("gif","jpg","png","jpeg"), 5242880 ) ); // 5mb
                        {
                            $haveError = true;
                            break;
                        }
                    }
                }

                // Проверяем количество файлов
                if( !$error && sizeof( $postImages["name"]["images"] ) >8 )
                {
                    $error = "Превышено максимально количество файлов";
                    $haveError = true;
                }

                if( !$error )
                {
                    for( $i=0;$i<sizeof( $postImages["name"]["images"] );$i++ )
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
                    $this->redirect( SiteHelper::createUrl("/catalog/add/saveImages/", array( "id"=>$id  )) );
                }
                else
                {
                    $this->render( "save", array("id"=>$id, "error"=>$error) );
                }
            }
            else throw new Exception( "Ошибка групповой закачи картиноку ( Указанному ID нет соответствующей записи )" );
        }
        else throw new Exception( "Ошибка групповой закачи картиноку ( Не указан ID )" );
    }
}