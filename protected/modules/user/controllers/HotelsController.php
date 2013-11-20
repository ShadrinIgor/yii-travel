<?php

class HotelsController extends Controller
{
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

    public function actionNopublish()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Запись снята с публикации";
            $message = "";

            $id = (int)Yii::app()->request->getParam("id", 0);
            if( !empty( $id ) )
            {
                $item = CatalogHotelsAdd::fetch( $id );
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
                $item = CatalogHotelsAdd::fetch( $id );
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
                $item = CatalogHotelsAdd::fetch( $id );
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

            $this->render( "description", array( "item"=>$item, "message"=>$message ) );
        }
    }

}
