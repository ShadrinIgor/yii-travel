<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Игорь
 * Date: 20.09.12
 * Time: 16:00
 * Виджет для вывода одной новости
 */
class galleryWidget extends CWidget
{
    public $catalog;
    public $item_id = 0;
    public function run()
    {

        $conditions = "catalog=:catalog";
        $params = array( ":catalog"=>$this->catalog );
        if( !empty($id) )
        {
            $conditions .= " sAND item_id=:item_id";
            $params = array_merge( $params, array( ":id"=>$id ) );
        }
        $images = CatGallery::fetchAll( DBQueryParamsClass::CreateParams()->setConditions( $conditions )->setParams( $params )->setLimit( 10 ) );

        $this->render( "gallery", array(
                    'images'      => $images
            ));
    }
}
