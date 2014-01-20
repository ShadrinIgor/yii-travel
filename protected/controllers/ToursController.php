<?php

class ToursController extends Controller
{
    var $slug;
	public function actionIndex()
	{
        $this->render( 'index' );
	}

    public function actionDescription()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);

        if( $id > 0 )
        {
            $item = CatalogTours::fetch( $id );
            if( $item->id >0 )
            {
                CCmodelHelper::colCounter( $item );
                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item" => $item,
                        "otherTours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:country_id AND id!=:id AND firm_id!=:firm_id")->setParams(array(":country_id"=>$item->country_id->id, ":id"=>$item->id, ":firm_id"=>$item->firm_id->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firmsTours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND firm_id=:firm_id AND id!=:id")->setParams(array(":firm_id"=>$item->firm_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->country_id->id ) ) ),
                        "firmCount" => CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item->country_id->id ) ) ),
                    ));

            }
                else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
    }
}