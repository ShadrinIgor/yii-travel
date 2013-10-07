<?php

class GalleryController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::app()->request->getParam("id", 0);

        $list_country = CatalogCountry::fetchAll();
        if( empty( $id ) )
        {
            $images = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog")->setParams(array(":catalog"=>"catalog_gardens_places"))->setLimit( 10 ) );
            $listTree = CatalogGardensTree::fetchAll( DBQueryParamsClass::CreateParams()->setLimit( 10 ) );
        }
            else
        {
            $images = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams(array(":catalog"=>"catalog_gardens_places", ":item_id"=>$id))->setLimit( 10 ) );
            $listTree = CatalogGardensTree::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("place_id=:place_id")->setParams(array(":place_id"=>$id))->setLimit( 10 ) );
        }


        $this->render("index", array( "list_country"=>$list_country, "images"=>$images, "trees"=>$listTree, "id"=>$id ));
    }

    public function actionTree()
    {
        $id = Yii::app()->request->getParam("id", 0);

        if( !empty( $id ) )
        {
            $images = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions("catalog=:catalog AND item_id=:item_id")->setParams(array(":catalog"=>"catalog_gardens_tree", ":item_id"=>$id))->setLimit( 10 ) );
            $tree = CatalogGardensTree::fetch( $id );

            $this->render("usertree", array( "images"=>$images, "tree"=>$tree ));
        }
    }
}
