<?php

class AdsUsersController extends InfoController
{
    public function init()
    {
        parent::init();
        $this->classModel = "CatalogItemsAdd";
        $this->classCategory = "";
        $this->description = "Самые популярные отели мира, отсортированные по рейтингу. Возможность просмотра подробного описания";
        $this->keyWord = "Полезная информация для туристов, архитектура, базары Узбекистана, банки Ташкента, великие люди, великий шелковый путь, автобусные путешествия, виза в Узбекистана, дети, культура / искусства, разновидности туризма, экстримальный туризм , рыбалка/охота, религия / духовные центры, кладбища";
    }

    public function actions(){

//        Yii::import('application.extensions.kcaptcha.KCaptchaAction');
//        Yii::app()->session->remove(KCaptchaAction::SESSION_KEY);

        return array(
            'captcha'=>array(
                'class' => 'application.extensions.kcaptcha.KCaptchaAction',
                'maxLength' => 6,
                'minLength' => 5,
                'foreColor' => array(mt_rand(0, 100), mt_rand(0, 100),mt_rand(0, 100)),
                'backColor' => array(mt_rand(200, 210), mt_rand(210, 220),mt_rand(220, 230))
            )
        );
    }

    public function actionIndex()
    {
        Yii::app()->page->title = "Частные объявления в туристической сфере";
        $p = (int)Yii::app()->request->getParam( "p", 1 );
        $saved = (int)Yii::app()->request->getParam( "saved", 0 );
        $categoryId = "status_id = 1";
        $categoryModel = new CatalogItemsCategory();

        foreach( $_GET as $key=>$item )
        {
            if( !empty( $_GET[$key] ) && $_GET[$key] != "null" )continue;
            $categoryModel = CatalogItemsCategory::fetchBySlug( $key );
            if( $categoryModel->id >0 )
            {
                $categoryId = $categoryModel->id;
            }
            break;
        }

        $addModel = new CatalogItemsAdd();

        if( !empty( $saved ) )
        {
            $addModel->formMessage = "Ваше объявление успешно опубликовано.<br/>Для добавления большого количества картинок для объявления или его редактирования пройдите по <a href=\"".SiteHelper::createUrl("/user/items/description", array( "id"=>$saved ) ) ."\">ссылке</a>";
        }

        $condition = "";
        $params = array( );

        if( $categoryId >0 )
        {
            $params =  array_merge( $params, array( ":category"=>$categoryId ) );
            $condition = " category_id=:category";
        }

        $items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $condition )->setParams( $params )->setCache(0)->setLimit( 25 )->setPage( $p )->setOrderBy( "id DESC" ) );

        $this->render( "index",
                array
                (
                    "items" => $items,
                    "categoryModel" => $categoryModel,
                    "addModel" => $addModel
                )
            );
    }

    public function actionSave()
    {
        $addModel = new CatalogItemsAdd();

        if( !empty( $_POST["CatalogItemsAdd"] ) && !Yii::app()->user->isGuest )
        {
            $addModel->setAttributesFromArray( $_POST["CatalogItemsAdd"] );
            $addModel->user_id = Yii::app()->user->getId();
            $addModel->status_id = 1;
            $addModel->active = 1;
            $addModel->date = time();
            if( $addModel->save( ) )
            {
                $id = $addModel->id;
                $this->redirect( SiteHelper::createUrl( "/adsUsers", array( "saved"=>$id ) ) );
            }
                else
            {
                $p = (int)Yii::app()->request->getParam( "p", 1 );
                $items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0)->setLimit( 25 )->setPage( $p )->setOrderBy( "id DESC" ) );
                $this->render( "index",
                    array
                    (
                        "items" => $items,
                        "addModel" => $addModel
                    )
                );
            }
        }
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
            $item = CatalogItems::fetch( $id );
            $item->setColView();
            if( $item->id >0 )
            {
                Yii::app()->page->title = $item->name;
                $this->render('description',
                    array(
                        "item" => $item,
                        "otherHotels" => CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("category_id=:category_id AND id!=:id")->setParams(array(":category_id"=>$item->category_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                        "usersOther" => CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("user_id=:user_id AND id!=:id")->setParams(array(":user_id"=>$item->user_id->id, ":id"=>$item->id))->setOrderBy("col DESC")->setLimit(8) ),
                    ));

            }
            else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
        }
        else throw new CHttpException("Ошибка","Ошибка перехода на страницу");
    }
}