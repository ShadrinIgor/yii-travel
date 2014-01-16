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
        $id = (int)Yii::app()->request->getParam("id", 0);

        if( $id > 0 )
        {
            $item = CatalogFirmsInfo::fetch( $id );
            if( $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item" => $item,
                        "otherFirms" => CatalogFirms::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND id!=:id")->setParams(array(":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "firmsTours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND firm_id=:firm_id")->setParams(array(":firm_id"=>$item->id))->setOrderBy("col DESC")->setLimit(-1) ),
                        "listGallery" => CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:items_id")->setParams(array(":catalog"=>"catalog_firms", ":items_id"=>$item->id))->setLimit(15) ),
                        "tourCount" => CatalogTours::count( DBQueryParamsClass::CreateParams()->setConditions( "firm_id=:firm_id" )->setParams( array( ":firm_id"=>$item->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
        else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
    }
}