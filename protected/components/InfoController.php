<?php

class InfoController extends Controller
{
    var $slug;
    var $classCountry = 'CatalogCountry';
    var $classModel = '';
    var $classCategory = '';
    var $description;
    var $keyWord;

	public function actionIndex()
	{
        $this->render( 'index' );
	}

    public function actionCountry()
    {
        if( !empty( $_GET["slug"] ) )
        {
            $class = $this->classCountry;
            $model = $class::fetchBySlug( trim( $_GET[ "slug" ] ) );

            if( $model->id >0 )
            {

                // Логируем просмотры стран и категорий для туров
                if( Yii::app()->controller->getId() == "tours" )
                {
                    LogHelper::saveCatLogCountry( $model->id );
                    LogHelper::saveCatLogParams( 0, 1 );
                }

                unset( $_GET["slug"] );
                $_GET["country_id"] = $model->id;
            }
        }

        $this->actionIndex();
    }

    public function actionCategory()
    {
        if( !empty( $_GET["slug"] ) )
        {
            $class = $this->classCategory;
            if( !empty( $class ) )
            {
                $model = $class::fetchBySlug( trim( $_GET[ "slug" ] ) );

                if( $model->id >0 )
                {
                    // Логируем просмотры стран и категорий для туров
                    if( Yii::app()->controller->getId() == "tours" )
                    {
                        LogHelper::saveCatLogCategory( $model->id );
                        LogHelper::saveCatLogParams( 1, 0 );
                    }

                    unset( $_GET["slug"] );
                    $_GET["category_id"] = $model->id;
                }
            }
        }
        $this->actionIndex();
    }

    public function actionDescription()
    {
        Yii::app()->page->setInfo( array( "description"=>$this->description, "keyWord"=>$this->keyWord ) );
        $id =0;
        $class = $this->classModel;
        $slug = !empty( $_GET[ "slug" ] ) ? $_GET[ "slug" ] : "";
        if( !empty( $_GET[ "slug" ] ) )
        {
            $model = $class::fetchBySlug( trim( $slug ) );
            if( $model->id >0 )
            {
                $_GET["id"]=$model->id;
                $id = $model->id;
            }
        }

        // Проверяем по ID
        if( $id == 0 )
        {
            $ar = explode( "-", $slug );
            if( (int)$ar[0] > 0 )
            {
                $model = $class::fetch( (int)$ar[0] );
                $id = $model->id;
            }
        }

        if( $id > 0 )
        {
            if( $model->id >0 )$item = $model;
                          else $item = $class::fetch( $id );

            if( $item->id >0 )
            {


                $images = ImageHelper::getImages( $item );
                $other = $class::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category_id AND id!=:id")->setParams(array(":category_id"=>$item->category_id->id, ":id"=>$item->id))->setOrderBy("id DESC")->setLimit(12) );

                $tourCategory = $item->tour_category;

                if( !empty($tourCategory) && sizeof( $tourCategory ) >0 )
                {
                    $dopSQL = " AND ( ";
                    $m=0;
                    foreach( $tourCategory as $tCategory )
                    {
                        if( $m > 0 )$dopSQL .= " OR ";
                        $dopSQL .= "category_id=".$tCategory->id;
                        $m++;
                    }
                    $dopSQL .= ") ";

                    $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( "country_id=:country_id ".$dopSQL )->setParams(array(":country_id"=>$item->country_id->id))->setOrderBy("rating DESC")->setLimit(9) );
                }
                    elseif( $item->country_id->id >0 )
                {
                    $tours = CatalogTours::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("country_id=:country_id")->setParams(array(":country_id"=>$item->country_id->id))->setOrderBy("rating DESC")->setLimit(10) );
                }
                    else $tours = array();

                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item"   => $item,
                        "other"  => $other ,
                        "images" => $images,
                        "tours"  => $tours,
                        "hotelCount" => $class::count( DBQueryParamsClass::CreateParams()->setConditions( "category_id=:category_id" )->setParams( array( ":category_id"=>$item->category_id->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );
        }
            else throw new CHttpException("Ошибка", Yii::t("page", "Ошибка перехода на страницу") );

    }
}