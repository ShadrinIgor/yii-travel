<?php

class ToursController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogTours";
        $this->classCategory = "CatalogToursCategory";
        $this->description = Yii::t("tours", "Список самых популярных туристических предложений, туров.");
        $this->keyWord = Yii::t("tours", "бизнес туры, деловой туризм, иследовательские, лечебные туры, развлектельные, vip отдых, детские лагеря, загородный отдых, конный тур, морские и речные круизы, рафтинг+экскурсии, сафари на верблюдах");
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        if( !empty( $_GET["slug"] ) )
        {
            $model = $class::fetchBySlug( trim( $_GET["slug"] ) );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
        }

        $error = Yii::t("page", "Произошла ошибка перехода на страницу, проверьте правильно написания адреса страницы");
        if( $id > 0 )
        {
            $item = CatalogTours::fetch( $id );
            if( $item->id >0 )
            {
                CCModelHelper::colCounter( $item );
                // Картинки тура
                $images = ImageHelper::getImages( $item );
                Yii::app()->page->title = $item->name.", тур ". $item->category_id->name .", ". $item->country_id->name ;
                $this->render('description',
                    array(
                        "item" => $item,
                        "images" => $images,
                        "otherTours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:country_id AND id!=:id AND firm_id!=:firm_id")->setParams(array(":country_id"=>$item->country_id->id, ":id"=>$item->id, ":firm_id"=>$item->firm_id->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firmsTours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND firm_id=:firm_id AND id!=:id")->setParams(array(":firm_id"=>$item->firm_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->country_id->id ) ) ),
                        "firmCount" => CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->country_id->id ) ) ),
                    ));

            }
                else throw new CHttpException( "", $error );
        }
            else throw new CHttpException( "", $error );
    }
}