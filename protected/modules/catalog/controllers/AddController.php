<?php

class AddController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->page->title = "Каталог продукции";

        if( !Yii::app()->user->isGuest )
        {
            $itemModel = new CatalogItemsAdd();
            if( !empty( $_POST["save_profile"] ) )
            {
                $itemModel->setAttributesFromArray( $_POST["CatalogItemsAdd"] );
                $itemModel->user_id = Yii::app()->user->id;
                $itemModel->status_id = 3; // По умолчанию не активен
                $itemModel->date = time();

                if( $itemModel->saveParam() )
                {
                    $itemModel->onAddItem( new CModelEvent( $itemModel ), array(
                            "id"      => $itemModel->id,
                            "subject"    => $itemModel->name,
                            "date"    => date("d.m.Y"),
                            "description" => SiteHelper::getSubTextOnWorld( $itemModel->description, 200 ),
                            "link"    => Yii::app()->params["adminEmail"].SiteHelper::createUrl("/user/items/description/", array("id"=>$itemModel->id))
                        )
                    );
                    $this->redirect( SiteHelper::createUrl("/catalog/add/save", array("id"=>$itemModel->id)));
                }
            }

            $addDopParams = null;
            if( $itemModel->category_id && $itemModel->category_id->id >0 )
            {
                $categoryModel = CatalogItemsCategory::fetch( $itemModel->category_id->id );
                if( $categoryModel->table_name  )
                {
                    $catalogClass = SiteHelper::getCamelCase( $categoryModel->table_name );
                    $addDopParams = new $catalogClass;
                }
            }

            $this->render( "add", array( "form"=>$itemModel, "addDopParams"=>$addDopParams ) );
        }
            else
        {
            Yii::app()->session['redirect'] = SiteHelper::createUrl("/catalog/add");
            $this->render( "addauthWidget" );
        }
	}

    function actionSave()
    {
        $id = (int) Yii::app()->request->getParam("id", 0 );
        $this->render( "save", array("id"=>$id) );
    }
}