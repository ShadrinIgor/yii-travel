<?php

class ServiceController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogFirmsService";
        $this->classCategory = "";
        $this->description = Yii::t("page", "Дополнительные услуги компании").".";
        $this->keyWord = Yii::t("page", "Дополнительные услуги компании").".";
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        if( !empty( $_GET[ "slug" ] ) )
        {
            $model = $class::fetchBySlug( trim( $_GET[ "slug" ] ) );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
        }

        $error = Yii::t("page", "Произошла ошибка перехода на страницу, проверьте правильно написания адресса страницы");
        if( $id > 0 )
        {
            $item = CatalogFirmsService::fetch( $id );
            if( $item->id >0 )
            {
                CCModelHelper::colCounter( $item );
                // Картинки тура
                $images = ImageHelper::getImages( $item );
                Yii::app()->page->title = $item->name." - ".Yii::t("page", "услуги от компании");
                $this->render('description',
                    array(
                        "item" => $item,
                        "images" => $images,
                        "firmsService" => CatalogFirmsService::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:firm_id AND id!=:id" )->setParams( array( ":firm_id"=>$item->firm_id, ":id"=>$item->id ) )->setCache(0) ),
                        "firmsItems"   => CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:firm_id" )->setParams( array( ":firm_id"=>$item->firm_id ) )->setCache(0) )
                    ));

            }
                else throw new CHttpException( "", $error );
        }
            else throw new CHttpException( "", $error );
    }
}