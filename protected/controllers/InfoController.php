<?php

class InfoController extends Controller
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