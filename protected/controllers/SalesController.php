<?php

class SalesController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogFirmsItems";
        $this->classCategory = "";
        $this->description = "Список самых популярных туристических предложений, туров.";
        $this->keyWord = "бизнес туры, деловой туризм, иследовательские, лечебные туры, развлектельные, vip отдых, детские лагеря, загородный отдых, конный тур, морские и речные круизы, рафтинг+экскурсии, сафари на верблюдах";
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

        $error = "Произошла ошибка перехода на страницу, проверьте правильно написания адресса страницы";
        if( $id > 0 )
        {
            $item = CatalogFirmsItems::fetch( $id );
            if( $item->id >0 )
            {
                CCModelHelper::colCounter( $item );
                // Картинки тура
                $images = ImageHelper::getImages( $item );
                Yii::app()->page->title = $item->name.", акция тур. фирмы ". $item->firm_id->name ;
                $this->render('description',
                    array(
                        "item" => $item,
                        "images" => $images,
                        "otherTours" => CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("active=1 AND id!=:id AND firm_id!=:firm_id")->setParams(array(":id"=>$item->id, ":firm_id"=>$item->firm_id->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firmsTours" => CatalogFirmsItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("active=1 AND id!=:id AND firm_id=:firm_id")->setParams(array(":id"=>$item->id, ":firm_id"=>$item->firm_id->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "tourCount" => CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions( "active=1 AND firm_id!=:firm_id" )->setParams( array( ":firm_id"=>$item->firm_id->id ) ) ),
                        "firmCount" => CatalogFirmsItems::count( DBQueryParamsClass::CreateParams()->setConditions( "active=1 AND firm_id=:firm_id" )->setParams( array( ":firm_id"=>$item->firm_id->id ) ) ),
                    ));

            }
                else throw new CHttpException( "", $error );
        }
            else throw new CHttpException( "", $error );
    }
}