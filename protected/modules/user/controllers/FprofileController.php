<?php

class FprofileController extends Controller
{
    public function actionIndex()
    {
        if( !Yii::app()->user->isGuest )
        {
            Yii::app()->page->title = "Мои заказы";
            $user = CatalogUsers::fetch( Yii::app()->user->id );
            $orders = OrderRequest::fetchAll( DBQueryParamsClass::CreateParams()->setCache(0)->setConditions( "user_id=:user_id" )->setParams( array( ":user_id"=>Yii::app()->user->id ) )->setLimit(200)->setOrderBy("date") );
            $this->render( "index", array( "user"=>$user, "orders"=>$orders ) );
        }
            else $this->redirect( SiteHelper::createUrl("/") );
    }

    public function actionRecharge()
    {
        if( !Yii::app()->user->isGuest )
        {
            $error = "";
            if( !empty( $_POST["recharge_submit"] ) )
            {

                $newPlantRequest = new OrderRequest();
                $price = (int) $_POST["price"];
                if( $price >0 )
                {
                    $newPlantRequest->user_id = Yii::app()->user->id;
                    $newPlantRequest->type_id = 2;
                    $newPlantRequest->status_id = 2;
                    $newPlantRequest->date = time();
                    $newPlantRequest->amount = $price;

                    if( $newPlantRequest->save() )
                    {
                        $this->redirect( SiteHelper::createUrl("/merchant/index", array( "id"=>$newPlantRequest->id )) );
                    }
                }
                    else $error = "Вы ввели не верную сумму";
            }

            Yii::app()->page->title = "Пополнения счета";

            $this->render( "recharge", array( "error"=>$error ) );
        }
            else $this->redirect( SiteHelper::createUrl("/") );
    }
}
