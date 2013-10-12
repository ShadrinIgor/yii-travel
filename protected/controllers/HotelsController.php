<?php

class HotelsController extends Controller
{
    var $slug;
	public function actionIndex()
	{
        $this->slug = Yii::app()->request->getParam("slug", "");
        if( empty( $this->slug ) )$this->index();
                       else $this->actionDescription();
	}

    public function index()
    {
        $this->render( 'index' );
    }

    public function actionDescription()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);

        if( $id > 0 )
        {
            $item = CatalogHotels::fetch( $id );
            if( $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item" => $item,
                        "otherHotels" => CatalogHotels::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:country_id AND city_id=:city_id AND id!=:id")->setParams(array(":country_id"=>$item->country_id->id, ":city_id"=>$item->city_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "hotelCount" => CatalogHotels::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->country_id->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
        else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
    }
}