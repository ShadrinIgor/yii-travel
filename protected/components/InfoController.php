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
            $model = $class::fetchBySlug( trim( $_GET[ "slug" ] ) );

            if( $model->id >0 )
            {
                unset( $_GET["slug"] );
                $_GET["category_id"] = $model->id;
            }
        }
        $this->actionIndex();
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
            if( $model->id >0 )$item = $model;
                          else $item = $class::fetch( $id );

            if( $item->id >0 )
            {
                $images = ImageHelper::getImages( $item );
                $other = $class::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category_id AND id!=:id")->setParams(array(":category_id"=>$item->category_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(24) );
                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item" => $item,
                        "other" => $other ,
                        "images" => $images,
                        "hotelCount" => $class::count( DBQueryParamsClass::CreateParams()->setConditions( "category_id=:category_id" )->setParams( array( ":category_id"=>$item->category_id->id ) ) ),
                    ));

            }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");

    }
}