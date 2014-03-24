<?php

class ItemsController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogFirmsItems";
        $this->classCategory = "";
        $this->description = "акции, скидки, распродажа туров, самые выгодные предложениея, горячие туры.";
        $this->keyWord = "акции, скидки, распродажа туров, самые выгодные предложениея, горячие туры";
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

        $error = "Произошла ошибка перехода на страницу, проверьте правильно написания адресса страницы";
        if( $id > 0 )
        {
            $item = CatalogFirmsItems::fetch( $id );
            if( $item->id >0 )
            {
                CCModelHelper::colCounter( $item );
                // Картинки тура
                $images = ImageHelper::getImages( $item );
                Yii::app()->page->title = $item->name." - акция скидка от компании";
                $this->render('description',
                    array(
                        "item" => $item,
                        "images" => $images,
                    ));

            }
                else throw new CHttpException( "", $error );
        }
            else throw new CHttpException( "", $error );
    }
}