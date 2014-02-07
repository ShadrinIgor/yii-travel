<?php

class TouristInfoController extends Controller
{
    var $slug;
	public function actionIndex()
	{
        $this->slug = Yii::app()->request->getParam("slug", "");
        if( empty( $this->slug ) )$this->index();
                       else $this->actionDescription();
	}

    public function index( )
    {

        $this->render( 'index' );
    }

    public function actionCountry()
    {

        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $class = "CatalogCountry";
            $model = $class::fetchBySlug( $key );
            if( $model->id >0 )
            {
                unset( $_GET[$key] );
                $_GET["country_id"] = $model->id;
            }
            break;
        }

        $this->actionIndex();
    }

    public function actionCategory()
    {
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $class = "CatalogInfoCategory";
            $model = $class::fetchBySlug( $key );
            if( $model->id >0 )
            {
                unset( $_GET[$key] );
                $_GET["category_id"] = $model->id;
            }
            break;
        }

        $this->actionIndex();
    }

    public function actionDescription()
    {
        $id =0;
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $class = "CatalogInfo";
            $model = $class::fetchBySlug( $key );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
            break;
        }

        if( $id > 0 )
        {
            $item = CatalogInfo::fetch( $id );
            if( $item->id >0 )
            {
                Yii::app()->page->title = $item->name;

                $this->render('description',
                    array(
                        "item" => $item,
                        "otherHotels" => CatalogInfo::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category_id AND id!=:id")->setParams(array(":category_id"=>$item->category_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(24) ),
                        "hotelCount" => CatalogInfo::count( DBQueryParamsClass::CreateParams()->setConditions( "category_id=:category_id" )->setParams( array( ":category_id"=>$item->category_id->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
        else throw new CHttpException("Ошибка","Ошибка перехода на страницу");

    }
}