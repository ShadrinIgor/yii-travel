<?php

class AdsUsersController extends Controller
{
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
        Yii::app()->page->title = "Объявления о работе в туристической сфере";
        $p = Yii::app()->request->getParam( "p", 1 );

        $items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0)->setLimit( 25 )->setPage( $p )->setOrderBy( "id" ) );

        $addModel = new CatalogItemsAdd();

        if( !empty( $_POST["CatalogItemsAdd"] ) )
        {
            $addModel->setAttributesFromArray( $_POST["CatalogItemsAdd"] );
            $addModel->user_id = Yii::app()->user->getId();
            $addModel->status_id = 1;
            if( $addModel->save( ) )
            {
                unset( $addModel );
                $addModel = new CatalogItems();
                $addModel->message = "Ваше объявление успешно опубликованно";
            }
        }

        $this->render( "index",
                array
                (
                    "items" => $items,
                    "addModel" => $addModel
                )
            );
    }

}