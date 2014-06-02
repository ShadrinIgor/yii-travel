<?php

class CountryController extends Controller
{
    var $description;
    var $keyWord;
    public function init()
    {
        parent::init();
        $this->description = Yii::t("country", "Туристический страны мира, описание, туристические достопримечательности" );
        $this->keyWord = Yii::t("country", "туристические страны мира, Турция, Египет, Болгария, Малайзия, ОАЭ, Таиланд" );
    }

    public function actionIndex()
    {
        $this->render( 'index' );
    }

    public function actionDescription()
    {
        if( !empty( $_GET["slug"] ) )
        {
            $model = CatalogCountry::fetchBySlug( trim( $_GET["slug"] ) );
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
                else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );
        }
            else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );

    }
}