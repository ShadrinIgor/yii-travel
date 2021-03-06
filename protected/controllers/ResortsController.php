<?php

class ResortsController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->layout = '//layouts/main2';
        $this->classModel = "CatalogKurorts";
        $this->classCategory = "CatalogKurortsCategory";
        $this->description = Yii::t("resorts", "Самые популярные курорты, зоны отдыха, детские лагеря, отсортированные по рейтингу. возможность просмотра подробного описания, галереи, дополнительных услуг цен и возможность отправить заказ");
        $this->keyWord = Yii::t("resorts", "курорты, зоны отдыха, детские лагеря, vip отдых, горные курорты, зоны отдыха в горах, горнолыжные/сноуборд, зона отдыха, отдых в горах, детский лагерь, лечебные");
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        if( !empty( $_GET[ "slug" ] ) )
        {
            $model = $class::fetchBySlug( trim( $_GET[ "slug" ] ) );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
        }

        if( $id > 0 )
        {
            LogHelper::save("resorts", $id, "show");
            $item = CatalogKurorts::fetch( $id );
            if( $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item" => $item,
                        "otherHotels" => CatalogKurorts::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("image>'' AND category_id=:category_id AND id!=:id")->setParams(array(":category_id"=>$item->category_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "hotelCount" => CatalogKurorts::count( DBQueryParamsClass::CreateParams()->setConditions( "category_id=:category" )->setParams( array( ":category"=>$item->category_id->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );
        }
        else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );
    }
}