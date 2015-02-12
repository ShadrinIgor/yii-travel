<?php

class AttractionsController extends Controller
{
    public function actionIndex()
    {
        Yii::app()->page->setTitle( "Достопримечательности Узбекистана" );

        $city = CatalogCity::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:cid")->setParams( array( ":cid"=>1 ) )->setOrderBy("name")->setLimit(-1) );
        $this->render( "index", array( "city"=>$city ) );
    }

    public function actionDescription()
    {
        $slug = Yii::app()->request->getParam("slug", "");
        if( !empty( $slug ) )
        {
            $item = CatalogAttractions::fetchBySlug( $slug );
            if( $item->id >0 )
            {
                Yii::app()->page->setTitle( $item->name );
                $list = CatalogAttractions::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("city_id=:cid AND id!=:id")->setParams( array( ":cid"=>$item->city_id->id, ":id"=>$item->id ) )->setLimit(4) );
                $images = ImageHelper::getImages( $item );
                $this->render( "description", array( "item"=>$item, "other"=>$list, "images"=>$images ) );
            }
        }
    }

    public function actionCity()
    {
        $slug = Yii::app()->request->getParam("slug", "");
        $city = CatalogCity::fetchBySlug( $slug );
        Yii::app()->page->setTitle( 'Достопримечательности '.$city->name2 );
        $this->render( "city", array( "city"=>$city ) );
    }

}