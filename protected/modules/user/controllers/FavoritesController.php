<?php

class FavoritesController extends Controller
{
    public function actionIndex()
    {
        if( !Yii::app()->user->isGuest )
        {
            $message = "";
            Yii::app()->page->title = Yii::t("user", "Избранное" );

            $userModel = CatalogUsers::fetch( Yii::app()->user->id );
            $del = (int)Yii::app()->request->getParam("del", 0);
            if( $del>0 )
            {
                Yii::app()->favorites->delete( $del, "catalog_items" );
            }

            $list = Yii::app()->favorites->getListId( "catalog=:catalog", array( ":catalog"=>"catalog_items" ) );
            if( sizeof( $list ) >0 )
            {
                $sql = " ( ";
                foreach( $list as $key=>$value )
                {
                    if( $sql != " ( " )$sql.=" OR ";
                    $sql .= "id='".$value."'";
                }
                $sql .= " )";
                $items = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("status_id=1")->setConditions( $sql )->setCache(0) );
            }
                else $items  = array();

            $this->render( "index", array( "message"=>$message, "items"=>$items, "userModel" =>$userModel ) );
        }
    }
}
