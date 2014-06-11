<?php

class ItemController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::app()->page->title = "Описание продукции";

        $id = (int)Yii::app()->request->getParam("id", 0);
        if( $id>0 )
        {
            $item = CatalogItems::fetchParam( $id );
            $otherItem = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id!=:id AND category_id=:cid")->setParams(array(":id"=>$item->id, ":cid"=>$item->category_id->id))->setOrderBy("price")->setLimit(10) );
            $hotItem = CatalogItems::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("id!=:id AND is_hot=:hot")->setParams(array(":id"=>$item->id, ":hot"=>1))->setOrderBy("price")->setLimit(10) );
            if( $item->id >0  )
            {

                $favorites = Yii::app()->request->getParam("favorites", "" );
                if( $favorites == "add" )
                {
                    $res = Yii::app()->favorites->add( "catalog_items", $item->id );
                }

                $newComment = new CatalogItemsCommentsAdd();
                // Сохраняем комментарий
                if( !empty( $_POST["sentComment"] ) )
                {
                    $newComment->setAttributesFromArray( $_POST["CatalogItemsCommentsAdd"] );
                    $newComment->date = time();
                    $newComment->user_id = Yii::app()->user->id;
                    $newComment->item_id = $id;

                    if( $newComment->save() )
                    {
                        $newComment->formMessage = "Комментарий успешно отправлен.";
                        $newComment->onNewComment( new CModelEvent( $newComment ), array(
                                "id"      => $item->id,
                                "name"    => $item->name,
                                "subject" => $newComment->subject,
                                "link"    => SiteHelper::createUrl("/user/items/index", array("id"=>$newComment->item_id)),
                            ));
                    }
                }

                $listComments = CatalogItemsComments::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("item_id=:item_id AND is_valid=1")->setParams(array( ":item_id"=>$item->id) )->setOrderBy("date DESC") );

                $this->render( "item", array( "item" =>$item, "otherItem"=>$otherItem, "hotItem"=>$hotItem, "addForm"=> $newComment, "listComments"=>$listComments ) );
            }
            else $this->redirect("/");
        }
        else $this->redirect("/");
	}
}