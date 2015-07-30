<?php

class CountryPageController extends Controller
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
        $page = (int)Yii::app()->request->getParam("p", 1);
        $this->layout = '//layouts/main-landing';
        if( !empty( $_GET["country"] ) )
        {
            $model = CatalogCountry::fetchBySlug( trim( $_GET["country"] ) );
        }

        if( $model && $model->id >0)
        {
            $item = $model;

            Yii::app()->page->setInfo( array( "description"=>$item->name.",".$this->description, "keyWord"=>$item->name.",".$this->keyWord ) );
            if( !empty( $item ) && $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
                $this->render('index',
                    array(
                        "item" => $item,
                        "page" => $page,
                        "tours" => CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND country_id=:id")->setParams(array(":id"=>$item->id))->setOrderBy("rating DESC")->setLimit(12) ),
                        "gallerySlide" => CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_country' AND type='slide-gallery' AND item_id=:id")->setParams(array(":id"=>$item->id))->setOrderBy("pos")->setLimit(-1) ),
                        "gallery" => CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog='catalog_country' AND type='' AND item_id=:id")->setParams(array(":id"=>$item->id))->setOrderBy("pos")->setLimit(9) ),
                        "info" => CatalogInfo::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "category_id=(SELECT id FROM catalog_info_category WHERE slug=:slug LIMIT 1)" )->setParams( array( ":slug"=>$item->slug ) ) ),
                        "monuments" => CatalogMonuments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:id" )->setParams( array( ":id"=>$item->id ) ) ),
                    ));
            }
                else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );
        }
            else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );

    }
}