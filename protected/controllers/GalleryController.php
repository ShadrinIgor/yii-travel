<?php

class GalleryController extends Controller
{
    public function actionIndex()
    {
        $id = Yii::app()->request->getParam("id", 0);

        $list_country = CatalogCountry::fetchAll();

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
