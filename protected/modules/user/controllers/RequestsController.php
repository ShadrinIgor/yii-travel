<?php

class RequestsController extends Controller
{
    public function actionIndex( )
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = Yii::t("user", "Мои заказы");
            $trees = PlantRequest::findByAttributes( array( "user_id"=>Yii::app()->user->id ) );
            $this->render( "index", array( "trees"=>$trees ) );
        }
    }

    public function actionOrderDel()
    {
        if( !Yii::app()->user->isGuest )
        {
            $messageOk = "";
            $messageEr = "";
            $order_id = (int) Yii::app()->request->getParam( "id", 0 );

            if(!empty($order_id))
            {
                $order = PlantRequest::fetch( $order_id );
                if( $order->id >0 && $order->user_id->id == Yii::app()->user->id && $order->del == 0 )
                {
                    if( $order->inBasket() )$messageOk =Yii::t("user",  "Заказ успешно удален");
                }
            }

            if( empty( $messageOk ) )$messageEr = Yii::t("user", "Произошла ошибка удаления заказа, попробуйте позже");

            $listOrders = PlantRequest::findByAttributes( array( "user_id"=>Yii::app()->user->id ) );
            $this->render( "index", array( "trees"=>$listOrders, "messageOk"=>$messageOk , "messageEr"=>$messageEr ) );
        }
    }
}
