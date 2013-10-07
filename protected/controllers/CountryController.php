<?php

class CountryController extends Controller
{
    public function actionIndex()
    {
        $this->render( 'index' );
    }

    public function actionDescription()
    {
        $id = (int) Yii::app()->request->getParam("id", 0 );

        if( !empty($this->slug) || !empty($id) )
        {
            if( !empty($this->slug) )
            {
                $itemModel = CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("slug=:slug")->setParams(array(":slug"=>$this->slug)) );
                if( sizeof($itemModel)>0 )$item = $itemModel[0];
            }
            if( !empty( $id ) && $id>0 )$item = CatalogCountry::fetch( $id );
            if( !empty( $item ) && $item->id >0 )
            {
                $this->render('description',
                    array(
                        "item" => $item,
                        "tours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:id")->setParams(array(":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firms" => CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:id")->setParams(array(":id"=>$item->id))->setOrderBy("rand()")->setLimit(12) ),
                        "otherCountry" => CatalogCountry::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id!=:id")->setParams(array(":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->id ) ) ),
                        "firmCount" => CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->id ) ) ),
                    ));
            }
                else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");

    }
}