<?php

class CountryController extends Controller
{
    var $description;
    var $keyWord;
    public function init()
    {
        parent::init();
        $this->description = "Туристический страны, описание, туристические достопримечательности";
        $this->keyWord = "туристические страны, Турция, Египет, Болгария, Малайзия, ОАЭ, Таиланд";
    }

    public function actionIndex()
    {
        $this->render( 'index' );
    }

    public function actionDescription()
    {
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $model = CatalogCountry::fetchBySlug( $key );
            if( $model->id >0 )break;
        }

        if( $model && $model->id >0)
        {
            $item = $model;

            Yii::app()->page->setInfo( array( "description"=>$item->name.",".$this->description, "keyWord"=>$item->name.",".$this->keyWord ) );
            if( !empty( $item ) && $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
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