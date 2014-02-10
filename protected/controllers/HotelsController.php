<?php

class HotelsController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogHotels";
        $this->classCategory = "";
        $this->description = "Самые популярные отели мира, отсортированные по рейтингу. Возможноть просмотра подробного описания";
        $this->keyWord = "Полезная информация для туристов, архитектура, базары узбекистана, банки тпшкента, великие люди, великий шелковый путь, автобусные путешествия, виза в узбекистан, дети, культура / искуства, разновидности туризма, эктримальный туризм , рыбалка/охота, религия / духовные центры, кладбища";
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
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