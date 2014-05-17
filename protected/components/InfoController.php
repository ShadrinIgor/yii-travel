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

        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $class = $this->classCountry;
            $model = $class::fetchBySlug( $key );
            if( $model->id >0 )
            {
                unset( $_GET[$key] );

                $_GET["country_id"] = $model->id;
            }
            break;
        }

        $this->actionIndex();
    }

    public function actionCategory()
    {
        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) )continue;
            $class = $this->classCategory;
            $model = $class::fetchBySlug( $key );

            if( $model->id >0 )
            {
                unset( $_GET[$key] );
                $_GET["category_id"] = $model->id;
            }
            break;
        }

        $this->actionIndex();
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