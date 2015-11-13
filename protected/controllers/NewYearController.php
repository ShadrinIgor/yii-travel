<?php

class NewYearController extends Controller
{
    public function actionIndex()
    {
        if( $this->beginCache( "newyear_".Yii::app()->getLanguage(), array('duration'=>1800) ) )
        {
            Yii::app()->page->title = "Новогодние туры со всего Узбекистана, 2015 год";
            $this->render('index', ["country" => CatalogCountry::fetchAll(DBQueryParamsClass::CreateParams()->setConditions("id IN ( SELECT country_id FROM catalog_tours WHERE is_newyear=1 AND active=1 )")->setOrderBy("rating DESC"))]);
            $this->endCache();
        }
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        if( !empty( $_GET["slug"] ) )
        {
            $model = $class::fetchBySlug( trim( $_GET["slug"] ) );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
                else
            {
                $arrId = explode( "-", $_GET["slug"] );
                if( sizeof( $arrId ) >0 )
                {
                    $id = (int)$arrId[0];
                }
            }
        }

        $error = Yii::t("page", "Произошла ошибка перехода на страницу, проверьте правильно написания адреса страницы");
        if( $id > 0 )
        {
            $item = CatalogTours::fetch( $id );
            if( $item->id >0 )
            {
                LogHelper::saveCatLogTours( $item->id );
                CCModelHelper::colCounter( $item );
                // Картинки тура
                Yii::app()->page->title = $item->name.", тур ". $item->category_id->name .", ". $item->country_id->name ;
                $this->render('description',
                    array(
                        "item" => $item,
                    ));

            }
                else throw new CHttpException( "", $error );
        }
            else throw new CHttpException( "", $error );
    }
}