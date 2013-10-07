<?php

class FirmsController extends Controller
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
        if( !empty($this->slug) )
        {
            $item = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("slug=:slug")->setParams(array(":slug"=>$this->slug)) );
            if( sizeof($item)>0 && $item[0]->id >0 )
            {
                $this->render('description',
                    array(
                        "item" => $item[0],
                        "tours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:id")->setParams(array(":id"=>$item[0]->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firms" => CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:id")->setParams(array(":id"=>$item[0]->id))->setOrderBy("rand()")->setLimit(12) ),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item[0]->id ) ) ),
                        "firmCount" => CatalogFirms::count( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country" )->setParams( array( ":country"=>$item[0]->id ) ) ),
                    ));
            }
                else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");

    }
}