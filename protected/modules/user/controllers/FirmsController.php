<?php

class FirmsController extends UserController
{
    public function init()
    {
        parent::init();
        $this->addModel = "CatalogFirmsAdd";
        $this->tableName = "catalog_firms";
        $this->name = "фирмы";
    }

    public function actionTourDelete()
    {
        Yii::app()->page->title = "Запись удалена";
        $message = "";

        $id = (int)Yii::app()->request->getParam("id", 0);
        $tid = (int)Yii::app()->request->getParam("tid", 0);
        if( !empty( $id ) && !empty( $tid ) )
        {

            $tableName = $this->addModel;
            $item = $tableName::fetch( $id );
            if( $item->id && $item->user_id->id == Yii::app()->user->getId() )
            {
                $tourModel = CatalogTours::fetch( $tid );
                if( $tourModel->id >0 && $tourModel->firm_id->id == $item->id )
                {
                    foreach( CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions(" item_id=:itemId AND catalog=:catalog ")
                        ->setParams( array( ":itemId"=>$tourModel->id, ":catalog"=>"catalog_tours" ) ) ) as $galItem )
                        $galItem->delete();

                    $tourModel->delete();

                    if( is_array($tourModel->getErrors()) && sizeof( $tourModel->getErrors() )>0 )
                        print_r( $tourModel->getErrors() );
                }
            }
        }

        $this->actionDescription( );
    }

    public function actionCommentRead()
    {
        $id = (int)Yii::app()->request->getParam("id", 0);
        if( $id >0 )
        {
            $commentModel = CatalogFirmsCommentsAdd::fetch( $id );
            if( $commentModel->id > 0 && $commentModel->user_id->id == Yii::app()->user->getId() )
            {
                $commentModel->is_new = 0;
                $commentModel->save();
                echo true;
                return;
            }
        }

        echo false;
        return;
    }
}
