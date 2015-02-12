<?php

class WeatherUzbekistanController extends Controller
{
    public function actionIndex()
    {
        Yii::app()->page->setTitle( "Погода Узбекистана" );
        $list = CatalogWhetersPages::fetchAll( DBQueryParamsClass::CreateParams()->setLimit(-1) );
        $this->render( "index", array( "list"=>$list ) );
    }

    public function actionDescription()
    {
        $slug = Yii::app()->request->getParam("slug", "");
        if( !empty( $slug ) )
        {
            $item = CatalogWhetersPages::fetchBySlug( "weather-".$slug );
            Yii::app()->page->setTitle( $item->name );
            $list = CatalogWheters::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("city_id=:id")->setParams( array( ":id"=>$item->city_id->id ) )->setLimit(-1) );
            $this->render( "description", array( "item"=>$item, "list"=>$list ) );
        }
            else $this->redirect( SiteHelper::createUrl( "/weather" ) );
    }

}